<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ticket, App\TicketRespond, App\Package, App\Role, App\User;
use DataTables, Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class AllTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cms.ticket.allticket.index');
    }

    public function datatables()
    {   
        if(Auth::check() && auth()->user()->role_id == ROLE::ROLE_WARGA){
            $arrSelect = [
                'users.username as customer',
                'tickets.ticket_number as ticket_number',
                'tickets.id',
                'tickets.subject as subject',
                'tickets.updated_at as updated_at',
                'tickets.status as status',
                'tickets.created_at as created_at'
            ];
            $data = DB::table('tickets')    
            ->join('user_has_subscription', 'tickets.users_has_packages_id', 'user_has_subscription.id')
            ->join('users', 'user_has_subscription.user_id', 'users.id')
            ->orderBy('tickets.created_at','desc')
            ->where('user_has_subscription.user_id', auth()->user()->id)
            ->select($arrSelect)
            ->get();
        }else{
            $arrSelect = [
                'users.username as customer',
                'tickets.ticket_number as ticket_number',
                'tickets.id',
                'tickets.subject as subject',
                'tickets.updated_at as updated_at',
                'tickets.status as status',
                'tickets.created_at as created_at'
            ];
            $data = DB::table('tickets')    
            ->join('user_has_subscription', 'tickets.users_has_packages_id', 'user_has_subscription.id')
            ->join('users', 'user_has_subscription.user_id', 'users.id')
            ->orderBy('tickets.created_at','desc')
            ->select($arrSelect)
            ->get();
        }

        return Datatables::of($data)         
        ->editColumn('ticket_number',
            function ($data){
                return $data->ticket_number;
        })               
        ->editColumn('subject',
            function ($data){
                return $data->subject;
        })               
        ->editColumn('customer',
            function ($data){
                return $data->customer;
        })               
        ->editColumn('created_at',
    
            function ($data){
                return  Carbon::parse($data->created_at)->diffForHumans();

        })               
        ->editColumn('created_at_sort',
    
            function ($data){
                return  $data->created_at;

        })               
        ->editColumn('status',
            function ($data){
                return \EnumTicket::status($data->status);

        })   
              
        ->editColumn('action',
            function ($data){                                
                    if ($data->status ==  \EnumTicket::STATUS_CLOSED){
                        return \Component::btnDelete(route('all-ticket-destroy', $data->id), 'Hapus Ticket '. $data->customer);
                    }
                    return
                    \Component::btnUpdate(route('all-ticket-edit', $data->id), 'Ubah Ticket '. $data->customer).
                    \Component::btnDelete(route('all-ticket-destroy', $data->id), 'Hapus Ticket '. $data->customer);
                    
        })
        ->addIndexColumn()
        ->rawColumns(['status', 'action']) 
        ->make(true);          
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subscription = DB::table('user_has_subscription')
            ->where('user_has_subscription.user_id', auth()->user()->id)
            ->join('subscription', 'user_has_subscription.subscription_id', 'subscription.id') 
            ->select([
                'subscription.name as name',
                'user_has_subscription.id as users_has_packages_id'
            ])
            ->get();
            

        return view('cms.ticket.allticket.create', compact ('subscription'));    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
   // 	'name' => 'required|string|max:255',
        //     'speed' => 'required|string|max:15',
        // ]);

        // $data = DB::table('user_has_subscription')
        // ->whereIn('user_id', auth()->user()->id)
        // ->select('id');

        // $ticket = new Ticket;

        // $ticket->user_id = Auth()->id();
        // $latestTicket = App\Ticket::orderBy('created_at','DESC')->first();
        // $ticket->ticket_nr = '#'.str_pad($latestTicket->id + 1, 8, "0", STR_PAD_LEFT);
  
        // $request ['users_has_packages_id'] = 1;
        $request ['ticket_number'] = Str::random(4);;
        $request ['status'] = 1;
        $request ['priority'] = 1;
        $request ['attachment'] = '-';
        $request ['description'] = $request->ckeditor;
        // $request ['description'] = '-';

        Ticket::create($request->except('_token'));

        // vardump ($request);
        // Ticket::create($request->only(
        // 'users_has_packages_id',
        // 'subject',
        // 'description',
        // 'priority',
        // 'departement',
        // 'attachment',
        // 'status',
        // 'ticket_number'
        // ));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arrSelect = [
            'users.username as customer',
            'tickets.id as id',
            'tickets.ticket_number as ticket_number',
            'tickets.subject as subject',
            'tickets.description',
            'tickets.updated_at as updated_at',
            'tickets.status as status',
            'tickets.updated_at as created_at',

        ];
        $data = DB::table('tickets')    
        ->join('user_has_subscription', 'tickets.users_has_packages_id', 'user_has_subscription.id')
        ->join('users', 'user_has_subscription.user_id', 'users.id')
        ->orderBy('tickets.created_at','desc')
        ->select($arrSelect)
        ->where('tickets.id', $id)
        ->first();
   
        $ticketsResponds = DB::table('ticket_respond')
        ->where('ticket_id', $data->id)
        ->orderBy('created_at', 'asc')
        ->get();
        
        // // $ticketsResponds=TicketRespond::findorFail('ticket_id','==',$data->id)->get;
        // //  $ticketsResponds = TicketRespond::where('ticket_id',$data->id)->firstOrFail($id);
        // // $user = TicketRespond::where('ticket_id', '=', $data->id)->first();
        // if (TicketRespond::where('ticket_id', '==', $data->id)->exists()) {
        // // $ticketsResponds = DB::table('ticket_respond')
        // // ->where('ticket_id', $data->id)
        // // ->orderBy('created_at', 'asc')
        // // ->get();
        // return 'ada';
        //  }else{
        //      return 'kososng';
        //  };
        // $ticketsResponds = TicketRespond::where('ticket_id', '==', $data->id)->exists();
        // if (is_null($ticketsResponds === null)) {
        //    return 'user doesn';
        // }else{return 'ini';};
        // return response()->json($ticketsResponds);
        return view('cms.ticket.allticket.edit', compact ('data', 'ticketsResponds'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'status'  =>  'required|max:10|integer'
        ]);

        $data = Ticket::where('id', $id)->first();
        if($data){
            $request['ticket_id']   = $id;
            $request['updated_at']  = now();
            $request['user_id']     = auth()->user()->id;
            $request ['respond']    = $request->ckeditor;


            $data->update($request->only('status', 'updated_at'));
            
            TicketRespond::Create($request->only('user_id', 'respond', 'ticket_id'));            

            return true;
        }
        
        return false;    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
