<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;
use App\Models\History;
use Carbon\Carbon;
use Auth;

class AdminController extends Controller
{
    public function index()
    {
    	return view('admin.index');
    }

    public function create_contact(){
    	return view('admin.create_contact');
    }

    public function datatables_contact(){
        
    	$contact = Contact::with('user','to_agent')->orderBy('created_at','desc');
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

    public function storecontact(Request $request){
        $input = $request->all();
        $contact = $input['contact'];
        // return $contact['name'];
        try {

            $data = [
                'name'          => $contact['name'],
                'phone'         => $contact['phone'],
                'email'         => $contact['email'],
                'status'        => 'Uncontacted',                
                'created_by'    => Auth::user()->id,
            ];

            // return $data;
            $insert = Contact::create($data);
            
            $data_history = [
                'contact_id' => $insert->id,
                'action'     => 'Create Contact',
                'remark'     => '',             
                'created_by' => Auth::user()->id,
            ];
            //history
            $history = self::add_history($data_history);

            
            $msg = array('TYPE' => 'S', 'MESSAGE' => 'Contact Saved');
            $result = ['code' => 200, 'data' => $msg];

            return response()->json($result);
        } catch (\Exception $e) {
            $error =  $e->getMessage() . " " . $e->getFile() . " " . $e->getLine();
            return response()->json($error);
        }
    }

    public function get_list_user(){
        
        $user = User::orderBy('name','asc');

        $val = [];
        if ($user->count()>0) {
            foreach ($user->get() as $key => $row) {
                
                $val[] = [
                    'id' => $row->id,
                    'name' => $row->name,
                ];
            }
        } else {
            $val = [];
        }

        return $val;
    }

    public function assigncontact(Request $request){
        $input      = $request->all();
        $contact    = $input['data'];
        $agent      = $contact['agent'];
        $id         = $contact['id'];
        $name       = $contact['name'];
        // return $name;
        try {

            // return $data;
            $data = array(
                        'agent'        => $agent,
                    );
            $update = Contact::where('id', $id)->update($data);
            
            //history
            $data_history = [
                'contact_id' => $id,
                'action'     => 'Assign Contact to '.$name,
                'remark'     => '',             
                'created_by' => Auth::user()->id,
            ];

            $history = self::add_history($data_history);

            
            $msg = array('TYPE' => 'S', 'MESSAGE' => 'Contact Assigned');
            $result = ['code' => 200, 'data' => $msg];

            return response()->json($result);
        } catch (\Exception $e) {
            $error =  $e->getMessage() . " " . $e->getFile() . " " . $e->getLine();
            return response()->json($error);
        }
    }

    public function updatecontact(Request $request){
        $input      = $request->all();
        $contact    = $input['contact'];
        $id_contact = $input['id_contact'];
        // return $contact['name'];
        try {

            $update = Contact::where('id', $id_contact)->update($contact);
            
            //history
            $data_history = [
                'contact_id' => $id_contact,
                'action'     => 'Update Contact',
                'remark'     => '',             
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

    public function deletecontact(Request $request){
        $input  = $request->all();
        $id     = $input['id'];
        // return $contact['name'];
        try {

            $delete = Contact::where('id', $id)->delete();
                        
            $msg = array('TYPE' => 'S', 'MESSAGE' => 'Contact Deleted');
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

    public function get_history($id){
       
       $contact = History::with('user')->where('contact_id',$id)->orderBy('created_at','desc');
        // return $contact->get();
        $r = 0;
        $val = [];
        if ($contact->count()>0) {
            foreach ($contact->get() as $key => $row) {
                
                $val[] = [
                    'no' => $r+1,
                    'action' => $row->action,
                    'remark' => $row->remark,
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

}
