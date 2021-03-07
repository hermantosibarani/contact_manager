<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;
use App\Models\History;
use Carbon\Carbon;
use Auth;

class UserController extends Controller
{
	public function index()
	{
		return view('user.index');
	}

	public function datatables_user_contact(){
        
    	$contact = Contact::with('user','to_agent')->where('agent', Auth::user()->id)->orderBy('created_at','desc');
        // return $contact->get();
        $r = 0;
        $val = [];
        if ($contact->count()>0) {
            foreach ($contact->get() as $key => $row) {
                
                $val[] = [
                    'no' => $r+1,
                    'id' => $row->id,
                    'name' => $row->name,
                    'phone' => $row->phone,
                    'email' => $row->email,
                    'remark' => $row->remark,
                    'status' => $row->status,
                    'agent' => !empty($row->to_agent->name)?$row->to_agent->name:'',
                    'created_by' => $row->user->name,
                    'created_at' => Carbon::parse($row->created_at)->format('Y-m-d'),
                ];
                $r++;
            }
        } else {
            $val = [];
        }
        $final['draw'] = 1;
        $final['recordsTotal'] = $r;
        $final['recordsFiltered'] = $r;
        $final['data'] = $val;
        return response()->json($final, 200);
    }

    public function user_updatecontact(Request $request){
        $input      = $request->all();
        $contact    = $input['contact'];
        $id_contact = $input['id_contact'];
        
        try {

            $update = Contact::where('id', $id_contact)->update($contact);
            
            //history
            $data_history = [
                'contact_id' => $id_contact,
                'action'     => 'Update status to '.$contact['status'],
                'remark'     => $contact['remark'],             
                'created_by' => Auth::user()->id,
            ];

            $history = self::add_history($data_history);

            
            $msg = array('TYPE' => 'S', 'MESSAGE' => 'Contact Updated');
            $result = ['code' => 200, 'data' => $msg];

            return response()->json($result);
        } catch (\Exception $e) {
            $error =  $e->getMessage() . " " . $e->getFile() . " " . $e->getLine();
            return response()->json($error);
        }
    }

    public function add_history($data){
       
        $insert = History::create($data);

    }
}
