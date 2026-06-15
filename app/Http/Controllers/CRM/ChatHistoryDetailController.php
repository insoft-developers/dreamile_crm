<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\WhatsappMessage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChatHistoryDetailController extends Controller
{
    public function index($id) {
        $view = 'chat-detail-report';
        return view('crm.reports.chat.detail.index', compact('view'));
    }

    public function table(Request $request)
    {
        if ($request->ajax()) {
            

            $data = WhatsappMessage::where('conversation_id', $request->filter_id);
            if ($request->filter_start_date && $request->filter_end_date) {
                $data->whereBetween('created_at', [
                    $request->filter_start_date . ' 00:00:00',
                    $request->filter_end_date . ' 23:59:59'
                ]);
            }

            $data->orderBy('id','asc');

            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('created_at', function ($row) {
                    return date('d-m-Y H:i', strtotime($row->created_at));
                })
                ->addColumn('sender', function ($row) {
                    return $row->sender == 'customer' ? '<div style="float:left;">'.$row->customer?->fullname.'</div>' : '<div style="float:right;"><strong>'.$row->user?->name.'(Agent)</strong></div>';
                })
                ->addColumn('chat_content', function ($row) {
                    $message = '';

                    if($row->type == 'image' && $row->attachment) {
                        $message .= '<a href="'.asset('/storage/'.$row->attachment).'" target="_blank"><img class="chat-image" src="'.asset('/storage/'.$row->attachment).'"></a>';
                        $message .= '<br>';
                    }

                    if($row->type == 'file' && $row->attachment) {
                        $message .= '<a href="'.asset('/storage/'.$row->attachment).'" target="_blank">'.$row->file_name.'</a>';
                        $message .= '<br>';
                    }
                    $message .= $row->message;


                    return $row->sender == 'customer' ? '<div style="float:left;color:blue;">'.$message.'</div>' : '<div style="float:right;">'.$message.'</div>';
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                
                

                ->rawColumns(['sender','chat_content'])
                ->make(true);
        }
    }
}
