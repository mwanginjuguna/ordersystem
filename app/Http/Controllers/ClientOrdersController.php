<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderReceivedEmailJob;
use App\Mail\OrderReceived;
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
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ClientOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        // all orders belonging to this client
        $clientId = auth()->user()->id;
        $clientOrders = Order::query()
            ->where('user_id', '=', $clientId)
            ->where('status', '=', 'running')
            ->latest()->get();
        return Inertia::render('ClientOrders/OrdersInProgress', ['orders' => $clientOrders]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function pending()
    {
        //
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.pending');
        }

        return Inertia::render('ClientOrders/OrdersPending', [
            'pendingOrders' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.recents');
        }
        return Inertia::render('ClientOrders/OrdersRecent', [
            'recents' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.submitted');
        }
        return Inertia::render('ClientOrders/OrdersSubmitted', [
            'submittedOrders' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.running');
        }
        return Inertia::render('ClientOrders/OrdersInProgress', [
            'runningOrders' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.completed');
        }
        return Inertia::render('ClientOrders/OrdersCompleted', [
            'completedOrders' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.cancelled');
        }

        return Inertia::render('ClientOrders/OrdersCancelled', [
            'cancelledOrders' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.revision');
        }
        return Inertia::render('ClientOrders/OrdersInRevision', [
            'revisionOrders' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.disputed');
        }

        return Inertia::render('ClientOrders/OrdersDisputed', [
            'disputedOrders' => Order::query()
                ->where('user_id', '=', auth()->user()->id)
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
        return Inertia::render('ClientOrders/OrderNew', [
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
     * Show the form for creating a new APIresource.
     *
     * @return JsonResponse
     */
    public function createApi(): JsonResponse
    {
        // new order form
        return response()->json([
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // validate and save
        $request->validate([
            'title' => 'required',
            'deadline' => 'required']);
        if (!Auth::check()) {
            if (!$request->name) {
                $credentials = $request->validate([
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]);

                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                }
            } else {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:'.User::class,
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                ]);

                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                event(new Registered($user));

                Auth::login($user);
            }
        }

        $order = new Order(
            $request->validate([
                'title' => 'required',
                'deadline' => 'required',
                "service_type_id"=> '',
                "academic_level_id"=> '',
                "subject_id"=> '',
                "instructions"=> '',
                "pages"=> '',
                "slides"=> '',
                "sources"=> '',
                "spacing_id"=> '',
                "referencing_style_id"=> '',
                "language_id"=> '',
                "writer_category_id"=> '',
                "amount"=> '',
                "currency_id"=> '',
                "cpp"=> '',
                "discount_id"=> '',
                "paid"=> ''
            ])
        );

        $order->user_id = auth()->user()->id;
        $order->amount_due = $request->amount;

        $order->due_at = Carbon::now()->addHours($order->deadline);
        $order->save();

        foreach ($request->file() as $filer) {
            foreach ($filer as $file) {
                $filename = auth()->id().'_'.$file->getClientOriginalName();
                $newFile = new File([
                    'order_id' => $order->id,
                    'name' => $filename,
                    'location' => Storage::putFileAs('orders', $file, $filename ),
                    'uploaded_by' => \auth()->user()->role
                ]);
                $newFile->save();
                }

        }
        $notify_admin = [
            'orderId' => $order->id,
            'username' => \auth()->user()->name,
            'title' => 'A New Order has been Placed.',
            'content' => 'A new Order has been placed. Order #'.$order->id.' by '.\auth()->user()->name.'.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];

        $admin = User::query()->where('role', '=', 'A')->first();

        $admin->notify(new AdminNotification($notify_admin));

        Mail::to($request->user())->later(
            delay: now()->addMinutes(1),
            mailable: new OrderReceived($order)
        );

        // dispatch(new SendOrderReceivedEmailJob(user: $request->user(), order: $order));

        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.pending')->with('success', 'Order added successfully');
        }

        return redirect()->route('orders.preview', [$order->id])
            ->with('success', 'Order added successfully.
            Complete Payment for Our experts to start working on it immediately.');
    }

    /**
     * Display the payment checkout page for an order.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function preview($id)
    {
        // view an order
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.show', $id);
        }

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

        $currency = Currency::query()
            ->where('id', '=', $order->currency_id)
            ->pluck('name')
            ->first();

        $deadline = Carbon::create($order->due_at)->diffForHumans(parts: 2);

        $files = File::query()
            ->where('order_id', '=', $order->id)
            ->latest()->get();

        return Inertia::render('ClientOrders/OrderPreview', [
            'order' => $order, 'level' => $level,
            'subject' => $subject, 'service' => $service,
            'spacing' => $spacing, 'style' => $refStyle,
            'language' => $language, 'writerCategory' => $writerCategory,
            'user' => $user, 'discount' => $discount,
            'writer' => $writer ?? null,
            'deadline' => $deadline,
            'files' => $files,
            'currencySymbol' => $currencySymbol,
            'currency' => $currency,
            'discountAmount' => $discountAmount
        ]);
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
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin');
        }

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

        $deadline = Carbon::create($order->due_at)->diffForHumans(parts: 2);
        $files = File::query()
            ->where('order_id', '=', $order->id)
            ->latest()->get();


        return Inertia::render('ClientOrders/OrderView', [
            'order' => $order, 'level' => $level,
            'subject' => $subject, 'service' => $service,
            'spacing' => $spacing, 'style' => $refStyle,
            'language' => $language, 'writerCategory' => $writerCategory,
            'user' => $user, 'discount' => $discount,
            'writer' => $writer ?? null,
            'deadline' => $deadline,
            'files' => $files,
            'currencySymbol' => $currencySymbol,
            'discountAmount' => $discountAmount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Upload files.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadFiles(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        foreach ($request->file() as $filer) {
            foreach ($filer as $file) {
                $filename = auth()->id().'_'.$file->getClientOriginalName();
                $newFile = new File([
                    'order_id' => $order->id,
                    'type' => 'OrderFile',
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markCompleted(Request $request, $id)
    {
        //
        if (auth()->user()->role === 'A') {
            return redirect()->route('admin.orders.complete', $id);
        }
        $order = Order::findOrFail($id);
        $order->status = "complete";
        $order->save();

        $notify_admin = [
            'orderId' => $order->id,
            'username' => \auth()->user()->name,
            'title' => 'Order #'.$order->id.' Completed.',
            'content' => 'An order has been marked Complete.
            Order #'.$order->id.' by '.\auth()->user()->name.'.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];
        $admin = User::query()->where('role', '=', 'A')->first();

        $admin->notify(new AdminNotification($notify_admin));

        return redirect()->route('orders.completed')->with('success', 'Order completed');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extendDeadline(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->deadline += $request->hours;
        $order->save();
        $notify_admin = [
            'orderId' => $order->id,
            'username' => \auth()->user()->name,
            'title' => 'Deadline Changed - Order #'.$order->id,
            'content' => 'The client has adjusted the deadline of an existing order.
            Order #'.$order->id.' by '.\auth()->user()->name.'.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];

        $admin = User::query()->where('role', '=', 'A')->first();

        $admin->notify(new AdminNotification($notify_admin));

        return redirect()->route('orders.running')->with('success', 'deadline update successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disputeOrder(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->status = "disputed";
        $order->cancel_reason = $request->cancel_reason;
        $order->save();

        $notify_admin = [
            'orderId' => $order->id,
            'username' => \auth()->user()->name,
            'title' => 'New Dispute! - Order #'.$order->id,
            'content' => 'An order has been disputed.
            Order #'.$order->id.' by '.\auth()->user()->name.'.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];

        $admin = User::query()->where('role', '=', 'A')->first();

        $admin->notify(new AdminNotification($notify_admin));

        return redirect()->route('orders.disputed')
            ->with('success', 'Dispute issued!! We will get back to you shortly with a resolution.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function requestRevision(Request $request, $id)
    {
        //
        $order = Order::findOrFail($id);
        $order->status = "revision";
        $order->revision_instructions = $request->revision_instructions;
        $order->save();

        $notify_admin = [
            'orderId' => $order->id,
            'username' => \auth()->user()->name,
            'title' => 'New Revision Request! - Order #'.$order->id,
            'content' => 'The client has requested a revision.
            Order #'.$order->id.' by '.\auth()->user()->name.'.',
            'url' => route('orders.show', $order->id),
            'action' => 'View Order'
        ];

        $admin = User::query()->where('role', '=', 'A')->first();

        $admin->notify(new AdminNotification($notify_admin));

        return redirect()->route('orders.revision')
            ->with('success', 'Revision request received. Our writer will start working on it now.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
        Order::findOrFail($id)
            ->delete();
        return redirect()->route('orders.recents')->with('success', 'Order removed successfully');
    }
}
