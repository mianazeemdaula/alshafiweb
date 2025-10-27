<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bonus;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
{
    /**
     * Display team structure and assignments
     */
    public function index()
    {
        $teamLeaders = User::role('team_leader')
            ->with(['teamMembers' => function($query) {
                $query->with(['manualOrders', 'bonuses']);
            }])
            ->get();

        $unassignedOrderTakers = User::role('order_taker')
            ->whereNull('team_leader_id')
            ->get();

        return view('admin.teams.index', compact('teamLeaders', 'unassignedOrderTakers'));
    }

    /**
     * Show form to assign order takers to team leader
     */
    public function assign()
    {
        $teamLeaders = User::role('team_leader')->get();
        $orderTakers = User::role('order_taker')->get();

        return view('admin.teams.assign', compact('teamLeaders', 'orderTakers'));
    }

    /**
     * Store team assignment
     */
    public function storeAssignment(Request $request)
    {
        $request->validate([
            'order_taker_id' => 'required|exists:users,id',
            'team_leader_id' => 'required|exists:users,id',
        ]);

        $orderTaker = User::findOrFail($request->order_taker_id);
        
        // Verify the user has order_taker role
        if (!$orderTaker->hasRole('order_taker')) {
            return back()->with('error', 'Selected user is not an order taker.');
        }

        // Verify team leader has team_leader role
        $teamLeader = User::findOrFail($request->team_leader_id);
        if (!$teamLeader->hasRole('team_leader')) {
            return back()->with('error', 'Selected user is not a team leader.');
        }

        $orderTaker->team_leader_id = $request->team_leader_id;
        $orderTaker->save();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Order taker assigned to team leader successfully.');
    }

    /**
     * Remove order taker from team
     */
    public function removeAssignment($orderTakerId)
    {
        $orderTaker = User::findOrFail($orderTakerId);
        
        if (!$orderTaker->hasRole('order_taker')) {
            return back()->with('error', 'User is not an order taker.');
        }

        $orderTaker->team_leader_id = null;
        $orderTaker->save();

        return back()->with('success', 'Order taker removed from team successfully.');
    }

    /**
     * Show team leader details with team members
     */
    public function show($id)
    {
        $teamLeader = User::role('team_leader')
            ->with(['teamMembers' => function($query) {
                $query->with(['manualOrders' => function($q) {
                    $q->latest()->limit(10);
                }, 'bonuses']);
            }])
            ->findOrFail($id);

        return view('admin.teams.show', compact('teamLeader'));
    }

    /**
     * Show all bonuses (admin view)
     */
    public function bonuses(Request $request)
    {
        $query = Bonus::with(['orderTaker', 'order']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by order taker
        if ($request->filled('order_taker_id')) {
            $query->where('order_taker_id', $request->order_taker_id);
        }

        $bonuses = $query->latest()->paginate(20);
        
        $orderTakers = User::role('order_taker')->get();
        
        $stats = [
            'total_pending' => Bonus::where('status', 'pending')->sum('bonus_amount'),
            'total_paid' => Bonus::where('status', 'paid')->sum('bonus_amount'),
            'total_cancelled' => Bonus::where('status', 'cancelled')->sum('bonus_amount'),
        ];

        return view('admin.teams.bonuses', compact('bonuses', 'orderTakers', 'stats'));
    }

    /**
     * Update bonus status
     */
    public function updateBonusStatus(Request $request, $bonusId)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $bonus = Bonus::findOrFail($bonusId);
        $bonus->status = $request->status;
        
        if ($request->status === 'paid') {
            $bonus->paid_at = now();
        }
        
        if ($request->filled('notes')) {
            $bonus->notes = $request->notes;
        }
        
        $bonus->save();

        return back()->with('success', 'Bonus status updated successfully.');
    }
}
