<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin as Admin;
use App\Mail\OrderSubmitted;
use App\Models\AcademicLevel;
use App\Models\AdditionalFeatures;
use App\Models\Currency;
use App\Models\Discount;
use App\Models\File;
use App\Models\Language;
use App\Models\Order;
use App\Models\Rate;
use App\Models\ReferencingStyle;
use App\Models\ServiceType;
use App\Models\Spacing;
use App\Models\Subject;
use App\Models\User;
use App\Models\WriterCategory;
use App\Notifications\AdminNotification;
use App\Notifications\WriterNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        //
         return Inertia::render('Admin/AllOrders', [
             'orders' => Order::query()->latest()->get()
         ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function pending()
    {
        //
        return Inertia::render('Orders/OrdersPending', [
            'pendingOrders' => Order::query()
                ->where('status', '=', 'pending')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function recents()
    {
        //
        return Inertia::render('Orders/OrdersRecent', [
            'recents' => Order::query()
                ->where('status', '=', 'new')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function submitted()
    {
        //
        return Inertia::render('Orders/OrdersSubmitted', [
            'submittedOrders' => Order::query()
                ->where('status', '=', 'submitted')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function running()
    {
        //
        return Inertia::render('Orders/OrdersInProgress', [
            'runningOrders' => Order::query()
                ->where('status', '=', 'running')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function completed()
    {
        //
        return Inertia::render('Orders/OrdersCompleted', [
            'completedOrders' => Order::query()
                ->where('status', '=', 'complete')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function cancelled()
    {
        //
        return Inertia::render('Orders/OrdersCancelled', [
            'cancelledOrders' => Order::query()
                ->where('status', '=', 'cancelled')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function revision()
    {
        //
        return Inertia::render('Orders/OrdersInRevision', [
            'revisionOrders' => Order::query()
                ->where('status', '=', 'revision')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function disputed()
    {
        //
        return Inertia::render('Orders/OrdersDisputed', [
            'disputedOrders' => Order::query()
                ->where('status', '=', 'disputed')
                ->latest()
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // new order form
        return Inertia::render('Orders/OrderNew', [
            'order' => new Order(),
            'levels' => AcademicLevel::all(),
            'subjects' => Subject::all(),
            'services' => ServiceType::all(),
            'rates' => Rate::all(),
            'styles' => ReferencingStyle::all(),
            'spacings' => Spacing::all(),
            'writerCategories' => WriterCategory::all(),
            'extras' => AdditionalFeatures::all(),
            'languages' => Language::all(),
            'currencies' => Currency::all(),
            'discounts' => Discount::query()->where('active', '=', '1')->get(),
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        // validate and save
        $order = new Order(
            $request->validate([
                'title' => 'required',
                'deadline' => 'required',
                "service_type_id" => '',
                "academic_level_id" => '',
                "subject_id" => '',
                "instructions" => '',
                "pages" => '',
                "slides" => '',
                "sources" => '',
                "spacing_id" => '',
                "referencing_style_id" => '',
                "language_id" => '',
                "writer_category_id" => '',
                "amount" => '',
                "currency_id" => '',
                "cpp" => '',
                "discount_id" => '',
                "paid" => '',
            ])
        );
        $order->user_id = auth()->user()->id;
        $order->due_at = Carbon::now()->addHours($order->deadline);
        $order->save();
        foreach ($request->files as $file) {
            $filename = auth()->id().'_'.$file->getClientOriginalName();
            $newFile = new File([
                'order_id' => $order->id,
                'name' => $filename,
                'location' => Storage::putFileAs('orders', $file, $filename )
            ]);
            $newFile->save();
        }

        return redirect()->route('orders.recents')->with('success', 'Order added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        // view an order
        $order = Order::findOrFail($id);
        $authUserRole = \auth()->user()->role;

        if (($order->status === 'new' || $order->status === 'pending') && $authUserRole === 'A')
        {
            $writers = User::query()
                ->where('role', '=', 'W')
                ->get();
        }


        $level = AcademicLevel::query()
            ->where('id', '=', $order->academic_level_id)
            ->pluck('name')
            ->first();

        $subject = Subject::query()
            ->where('id', '=', $order->subject_id)
            ->pluck('name')
            ->first();
        $service = ServiceType::query()
            ->where('id', '=', $order->service_type_id)
            ->pluck('name')
            ->first();
        $spacing = Spacing::query()
            ->where('id', '=', $order->spacing_id)
            ->pluck('name')
            ->first();
        $refStyle = ReferencingStyle::query()
            ->where('id', '=', $order->referencing_style_id)
            ->pluck('name')
            ->first();
        $language = Language::query()
            ->where('id', '=', $order->language_id)
            ->pluck('name')
            ->first();
        $writerCategory = WriterCategory::query()
            ->where('id', '=', $order->writer_category_id)
            ->pluck('name')
            ->first();
        $user = User::query()
            ->where('id', '=', $order->user_id)
            ->pluck('name')
            ->first();
        $writer = User::query()
            ->where('id', '=', $order->assigned_to)
            ->pluck('name')
            ->first();
        $discount = Discount::query()
            ->where('id', '=', $order->discount_id)
            ->pluck('code')
            ->first();
        $discountAmount = Discount::query()
                    ->where('id', '=', $order->discount_id)
                    ->pluck('rate')
                    ->first();
        $currencySymbol = Currency::query()
            ->where('id', '=', $order->currency_id)
            ->pluck('symbol')
            ->first();

        $deadline = Carbon::create($order->due_at)->diffForHumans(parts: 3);
        $files = File::query()
            ->where('order_id', '=', $order->id)
            ->latest()->get();
        //$filenames = [];
        //foreach ($files as $file)
        //{
        //    $filenames[] = base_path().Storage::url('app/orders/'.$file->name);
        //}

        return Inertia::render('Admin/ViewOrder', [
            'order' => $order, 'level' => $level,
            'subject' => $subject, 'service' => $service,
            'spacing' => $spacing, 'style' => $refStyle,
            'language' => $language, 'writerCategory' => $writerCategory,
            'user' => $user, 'discount' => $discount,
            'writers' => $writers ?? null,
            'writer' => $writer ?? null,
            'deadline' => $deadline,
            'discountAmount' => $discountAmount,
            'currencySymbol' => $currencySymbol,
            'files' => $files
        ]);
    }

    /**
     * @param $id
     * @return StreamedResponse
     */
    public function downloadFile($id): StreamedResponse
    {
        $file = File::findOrFail($id);
        return Storage::download($file->location);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return \Inertia\Response
     */
    public function edit(Order $order): \Inertia\Response
    {
        // edit an order
        return Inertia::render('Orders/OrderView', [
            'order' => $order
        ]);
    }

    /**
     * Show a file to the client.
     *
     * @param File $file
     * @return JsonResponse
     */
    public function showClient(File $file): JsonResponse
    {
        if ($file->show_client) {
            // hide if visible
            $file->show_client = false;
        } else {
            // show
            $file->show_client = true;
        }
        // save
        $file->save();
        // json response
        return response()->json([
            "message" => "File updated Successfully"
        ]);
    }

    /**
     * Delete a file.
     *
     * @param File $file
     * @return JsonResponse
     */
    public function destroyFile(File $file): JsonResponse
    {
        $file->delete();

        // json response
        return response()->json([
            "message" => "File Removed from database."
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->instructions = $request->instructions;
        $order->save();

        return redirect()->route('orders.show', [
            'id' => $id
        ])->with('success', 'instructions update successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function assignWriter(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->status = "running";
        $order->assigned_to = $request->assigned_to;
        $order->writer_deadline = Carbon::parse($request->writerDeadline);
        // send email to writer
        $writer = User::query()->where('id', '=', $order->assigned_to)->first();

        $data = [
            'orderId' => $order->id,
            'username' => $writer->name,
            'title' => 'New Order Assigned.',
            'content' => 'We have considered you for Order #'.$order->id.', and you have been assigned to work on it.
            You are expected to Login to your account, Check the assigned order, and Start working on it immediately.
            <br>Order Topic: '.$order->title.'<br> Order Instructions: <br>'.$order->instructions.'
            <br>A delivery is expected before the deadline of the order expires.
            As usual, plagiarism free and high quality work is expected.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];
        $writer->notify(new WriterNotification($data));

        $order->save();

        return redirect()->route('orders.show', [
            'id' => $id
        ])->with('success', 'Assigned to '.$writer->name);
    }

    /**
     * Submit an order for client to review.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function markCompleted(Request $request, $id)
    {
        // upload files, change order status to submitted, notify admin and client
        $order = Order::findOrFail($id);
        $order->status = "submitted";

        foreach ($request->files as $file) {
            $filename = $order->id.'_'.$file->getClientOriginalName();
            $newFile = new File([
                'order_id' => $order->id,
                'name' => $filename,
                'location' => Storage::putFileAs('orders', $file, $filename ),
                'uploaded_by' => \auth()->user()->role,
                'type' => $request->file_type
            ]);
            $newFile->save();
        }
        $notifyAdmin = [
            'orderId' => $order->id,
            'username' => \auth()->user()->name,
            'title' => 'Order #'.$order->id.' Submitted by '.\auth()->user()->name,
            'content' => 'Order #'.$order->id.' has been submitted.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];
        $admin = User::query()->where('role', '=', 'A')->first();

        $admin->notify(new AdminNotification($notifyAdmin));

        $client = User::query()->where('id', '=', $order->user_id)->first();

        Mail::to($client)->queue(new OrderSubmitted($order));

        $order->save();

        return redirect()->route('orders.show', [
            'id' => $id
        ])->with('success', 'Order Submitted');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function extendDeadline(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->deadline += $request->hours;

        $order->due_at = Carbon::now()->addHours($order->deadline);
        $order->save();

        return redirect()->route('orders.show', [
            'id' => $id
        ])->with('success', 'deadline update successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function markCancelled(Request $request, $id)
    {
        // change order status to cancelled, notify admin
        $order = Order::findOrFail($id);
        $order->status = "cancelled";
        $order->cancel_reason = $request->cancel_reason;
        $order->save();

        $notifyAdmin = [
            'orderId' => $order->id,
            'username' => \auth()->user()->name,
            'title' => 'Order #'.$order->id.' Cancelled.',
            'content' => 'Order #'.$order->id.' has been Cancelled.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];

        $admin = User::query()->where('role', '=', 'A')->first();

        $admin->notify(new AdminNotification($notifyAdmin));

        return redirect()->route('orders.show', [
            'id' => $id
        ])->with('success', 'Order Cancelled!!');
    }

    /**
     * Upload files.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function uploadFiles(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        foreach ($request->file() as $filer) {
            foreach ($filer as $file) {
                $filename = $order->id.'_'.$file->getClientOriginalName();
                $newFile = new File([
                    'order_id' => $order->id,
                    'type' => $request->fileType,
                    'name' => $filename,
                    'location' => Storage::putFileAs('orders', $file, $filename ),
                    'uploaded_by' => \auth()->user()->role
                ]);
                $newFile->save();
            }
        }
        return redirect()->back()->with('success', 'New File Upload was successful.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function disputeOrder(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->status = "disputed";
        $order->cancel_reason = $request->cancel_reason;
        $order->save();

        return redirect()->route('orders.show', [
            'id' => $id
        ])->with('success', 'Dispute issued!! We will get back to you shortly with a resolution.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function requestRevision(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->status = "revision";
        $order->revision_instructions = $request->revision_instructions;
        $order->save();

        return redirect()->route('orders.show', [
            'id' => $id
        ])->with('success', 'Revision request received. Our writer will start working on it now.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        //
        Order::findOrFail($id)
            ->delete();
        return redirect()->route('orders.recents')->with('success', 'Order removed successfully');
    }
}
