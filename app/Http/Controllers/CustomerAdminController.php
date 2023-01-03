<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Customer_Info;
use App\Customer_Transport;
use App\Http\Controllers\Controller;
use App\Order_Detail_Status;
use App\Order_Item;
use App\Orders;
use App\Product;
use App\Voucher;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Mail\Transport\Transport;
use Illuminate\Support\Facades\DB;

class CustomerAdminController extends Controller
{
    public static function check_voucher_order($order_id)
    {
        $order = Orders::find($order_id);
        $all_voucher = Voucher::all();
        $all_order_item = Order_Item::where('order_id', $order_id)->get();

        $voucher_amount = 0;
        $product_id_voucher = 0;
        $qty_product = 0;
        $val_discount_voucher = 0;
        $voucher_code = $order->voucher_code;
        if ($voucher_code != null) {
            foreach ($all_voucher as $voucher) {
                if ($voucher->voucher_code == $voucher_code) {
                    $voucher_amount = $voucher->voucher_amount;
                    $product_id_voucher = $voucher->product_id;
                    break;
                }
            }
        }
        foreach ($all_order_item as $order_item) {
            if ($product_id_voucher == $order_item->product_id) {
                $qty_product = $order_item->quantity_product;
                $val_discount_voucher = $qty_product * $voucher_amount;
                break;
            }
        }
        return $val_discount_voucher;
    }
    //
    public function all_customer()
    {
        $all_customer = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->orderBy('customer.customer_id', 'desc')
            ->paginate(10);
        $all_order = Orders::all();
        return view('admin.customer.all_customer', compact('all_order', 'all_customer'));
    }
    public function detail_customer($customer_id)
    {
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
        $customer_trans = Customer_Transport::where('customer_id', $customer_id)->where('trans_status', 1)->first();
        $all_order = Orders::where('customer_id', $customer_id)->orderBy('create_at', 'desc')->get();
        $all_order_item = Order_Item::all();
        $all_product = Product::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();
        $trans = Customer_Transport::all();
        $payment_method = DB::table('payment_method')->get();
        $all_voucher = Voucher::all();
        return view('admin.customer.detail_customer', compact(
            'customer',
            'customer_info',
            'customer_trans',
            'all_order',
            'all_order_item',
            'all_product',
            'all_order_detail_status',
            'status_order',
            'payment_method',
            'trans',
            'all_voucher',
            'customer_id'
        ));
    }
    public function find_customer(Request $request)
    {
        $val_find_customer = $request->value_find;
        $all_order = Orders::all();
        $all_customer = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->where('customer.username', 'LIKE', '%' . $val_find_customer . '%')
            ->orwhere('customer.email', 'LIKE', '%' . $val_find_customer . '%')
            ->orwhere('customer_info.customer_phone', 'LIKE', '%' . $val_find_customer . '%')
            ->get();
        return view('admin.customer.find_result_customer', compact('all_customer', 'all_order'));
    }

    public function filter_order_customer_follow_price_choose(Request $request)
    {
        $customer_id = $request->customerId;
        $all_order_item = Order_Item::all();
        $all_product = Product::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();
        $trans = Customer_Transport::all();
        $payment_method = DB::table('payment_method')->get();
        $all_voucher = Voucher::all();
        $level_filter_price = $request->radioTotalPrice;

        $type_filter = 'price';
        $level_filter = $level_filter_price;

        $price_start = 0;
        $price_end = 0;
        if ($level_filter_price == 1) {
            $price_start = 1000;
            $price_end = 100000;
        } else if ($level_filter_price == 2) {
            $price_start = 100000;
            $price_end = 500000;
        } else if ($level_filter_price == 3) {
            $price_start = 500000;
            $price_end = 1000000;
        } else if ($level_filter_price == 4) {
            $price_start = 1000000;
            $price_end = 2000000;
        }
        $string_title = 'Đơn Hàng Theo Tổng Tiền " Từ ' . number_format($price_start, 0, ',', '.')
            . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';
        $all_order = Orders::where('customer_id', $customer_id)
            ->where('total_price', '<=', $price_end)
            ->where('total_price', '>=', $price_start)
            ->orderBy('create_at', 'desc')
            ->get();
        echo view('admin.customer.view_filter_order_customer', compact(
            'string_title',
            'all_order',
            'all_order_item',
            'all_product',
            'all_order_detail_status',
            'status_order',
            'payment_method',
            'trans',
            'all_voucher',
            'type_filter',
            'level_filter',
            'customer_id'
        ));
    }
    public function filter_order_customer_follow_price_cus_option(Request $request)
    {
        $customer_id = $request->customerId;
        $all_order_item = Order_Item::all();
        $all_product = Product::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();
        $trans = Customer_Transport::all();
        $payment_method = DB::table('payment_method')->get();
        $all_voucher = Voucher::all();
        $price_start = $request->totalPriceStart;
        $price_end = $request->totalPriceEnd;

        $type_filter = 'price_many';
        $level_filter = '';
        $price_filter_start = $price_start;
        $price_filter_end = $price_end;


        $string_title = 'Đơn Hàng Theo Tổng Tiền " Từ ' . number_format($price_start, 0, ',', '.')
            . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';
        $all_order = Orders::where('customer_id', $customer_id)
            ->where('total_price', '<=', $price_end)
            ->where('total_price', '>=', $price_start)
            ->orderBy('create_at', 'desc')
            ->get();
        echo view('admin.customer.view_filter_order_customer', compact(
            'string_title',
            'all_order',
            'all_order_item',
            'all_product',
            'all_order_detail_status',
            'status_order',
            'payment_method',
            'trans',
            'all_voucher',
            'type_filter',
            'level_filter',
            'customer_id',
            'price_filter_start',
            'price_filter_end'
        ));
    }

    public function filter_order_customer_follow_date_single(Request $request)
    {
        $customer_id = $request->customerId;
        $all_order_item = Order_Item::all();
        $all_product = Product::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();
        $trans = Customer_Transport::all();
        $payment_method = DB::table('payment_method')->get();
        $all_voucher = Voucher::all();
        $date = $request->date;
        $date_filter = date('Y-m-d', strtotime($date));

        $type_filter = 'date';
        $level_filter = $date_filter;

        $string_title = 'Đơn Hàng Theo Ngày "' . date('d/m/Y', strtotime($date)) . '"';
        $all_order_customer = Orders::where('customer_id', $customer_id)->get();
        $arrayOrder = [];
        foreach ($all_order_customer as $order) {
            $date_create = date('Y-m-d', strtotime($order->create_at));
            if ($date_filter == $date_create) {
                $arrayOrder[] = $order;
            }
        }
        $all_order = array_reverse($arrayOrder);

        echo view('admin.customer.view_filter_order_customer', compact(
            'string_title',
            'all_order',
            'all_order_item',
            'all_product',
            'all_order_detail_status',
            'status_order',
            'payment_method',
            'trans',
            'all_voucher',
            'type_filter',
            'level_filter',
            'customer_id'
        ));
    }

    public function filter_order_customer_follow_date_many(Request $request)
    {
        $customer_id = $request->customerId;
        $all_order_item = Order_Item::all();
        $all_product = Product::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();
        $trans = Customer_Transport::all();
        $payment_method = DB::table('payment_method')->get();
        $all_voucher = Voucher::all();

        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $date_filter_start = date('Y-m-d', strtotime($date_start));
        $date_filter_end = date('Y-m-d', strtotime($date_end));

        $type_filter = 'date_many';
        $level_filter = '';
        $start_date = $date_filter_start;
        $end_date = $date_filter_end;

        $string_title = 'Đơn Hàng " Từ Ngày ' . date('d/m/Y', strtotime($date_start)) . '
                        Đến Ngày ' . date('d/m/Y', strtotime($date_filter_end)) . ' "';
        $all_order_customer = Orders::where('customer_id', $customer_id)->get();
        $arrayOrder = [];
        foreach ($all_order_customer as $order) {
            $date_create = date('Y-m-d', strtotime($order->create_at));
            if ($date_filter_start <= $date_create && $date_create <= $date_filter_end) {
                $arrayOrder[] = $order;
            }
        }
        $all_order = array_reverse($arrayOrder);

        echo view('admin.customer.view_filter_order_customer', compact(
            'string_title',
            'all_order',
            'all_order_item',
            'all_product',
            'all_order_detail_status',
            'status_order',
            'payment_method',
            'trans',
            'all_voucher',
            'type_filter',
            'level_filter',
            'customer_id',
            'start_date',
            'end_date'
        ));
    }

    public function print_pdf_order_customer(Request $request, $customer_id)
    {
        $customer = Customer::where('customer_id', $customer_id)->first();
        $customer_info = Customer_Info::where('customer_id', $customer_id)->first();
        $customer_trans = Customer_Transport::where('customer_id', $customer_id)->where('trans_status', 1)->first();
        $all_order = Orders::where('customer_id', $customer_id)->orderBy('create_at', 'desc')->get();
        $all_order_item = Order_Item::all();
        $all_product = Product::all();
        $all_order_detail_status = Order_Detail_Status::all();
        $status_order = DB::table('status_order')->get();
        $trans = Customer_Transport::all();
        $payment_method = DB::table('payment_method')->get();
        $all_voucher = Voucher::all();

        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;


        switch ($type_filter) {
            case "price":
                $price_start = 0;
                $price_end = 0;
                if ($level_filter == 1) {
                    $price_start = 1000;
                    $price_end = 100000;
                } else if ($level_filter == 2) {
                    $price_start = 100000;
                    $price_end = 500000;
                } else if ($level_filter == 3) {
                    $price_start = 500000;
                    $price_end = 1000000;
                } else if ($level_filter == 4) {
                    $price_start = 1000000;
                    $price_end = 2000000;
                }
                $string_title = 'Đơn Hàng Theo Tổng Tiền " Từ ' . number_format($price_start, 0, ',', '.')
                    . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';
                $all_order = Orders::where('customer_id', $customer_id)
                    ->where('total_price', '<=', $price_end)
                    ->where('total_price', '>=', $price_start)
                    ->orderBy('create_at', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.customer.view_print_pdf_order_customer', compact(
                    'string_title',
                    'all_order',
                    'all_order_item',
                    'all_product',
                    'all_order_detail_status',
                    'status_order',
                    'payment_method',
                    'trans',
                    'all_voucher'
                ));
                return $pdf->download('danhsachdonhangtheogia.pdf');
                break;
            case "price_many":
                $price_start = $request->price_filter_start;
                $price_end = $request->price_filter_end;
                $string_title = 'Đơn Hàng Theo Tổng Tiền " Từ ' . number_format($price_start, 0, ',', '.')
                    . '₫ Đến ' . number_format($price_end, 0, ',', '.') . '₫ "';
                $all_order = Orders::where('customer_id', $customer_id)
                    ->where('total_price', '<=', $price_end)
                    ->where('total_price', '>=', $price_start)
                    ->orderBy('create_at', 'desc')
                    ->get();
                $pdf = PDF::loadView('admin.customer.view_print_pdf_order_customer', compact(
                    'string_title',
                    'all_order',
                    'all_order_item',
                    'all_product',
                    'all_order_detail_status',
                    'status_order',
                    'payment_method',
                    'trans',
                    'all_voucher'
                ));
                return $pdf->download('danhsachdonhangtheogiatuchon.pdf');

                break;
            case "date":
                $date_filter = date('Y-m-d', strtotime($level_filter));

                $string_title = 'Đơn Hàng Theo Ngày "' . date('d/m/Y', strtotime($level_filter)) . '"';
                $all_order_customer = Orders::where('customer_id', $customer_id)->get();
                $arrayOrder = [];
                foreach ($all_order_customer as $order) {
                    $date_create = date('Y-m-d', strtotime($order->create_at));
                    if ($date_filter == $date_create) {
                        $arrayOrder[] = $order;
                    }
                }
                $all_order = array_reverse($arrayOrder);
                $pdf = PDF::loadView('admin.customer.view_print_pdf_order_customer', compact(
                    'string_title',
                    'all_order',
                    'all_order_item',
                    'all_product',
                    'all_order_detail_status',
                    'status_order',
                    'payment_method',
                    'trans',
                    'all_voucher'
                ));
                return $pdf->download('danhsachdonhangtheongay.pdf');
                break;
            case "date_many":
                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $string_title = 'Đơn Hàng " Từ Ngày ' . date('d/m/Y', strtotime($start_date)) . '
                        Đến Ngày ' . date('d/m/Y', strtotime($end_date)) . ' "';
                $all_order_customer = Orders::where('customer_id', $customer_id)->get();
                $arrayOrder = [];
                foreach ($all_order_customer as $order) {
                    $date_create = date('Y-m-d', strtotime($order->create_at));
                    if ($start_date <= $date_create && $date_create <= $end_date) {
                        $arrayOrder[] = $order;
                    }
                }
                $all_order = array_reverse($arrayOrder);
                $pdf = PDF::loadView('admin.customer.view_print_pdf_order_customer', compact(
                    'string_title',
                    'all_order',
                    'all_order_item',
                    'all_product',
                    'all_order_detail_status',
                    'status_order',
                    'payment_method',
                    'trans',
                    'all_voucher'
                ));
                return $pdf->download('danhsachdonhangtheonhieungay.pdf');
                break;
            default:
                $string_title = 'Danh Sách Đơn Hàng Của Khách Hàng ' . $customer->username;
                $pdf = PDF::loadView(
                    'admin.customer.view_print_pdf_order_customer',
                    compact(
                        'string_title',
                        'all_order',
                        'all_order_item',
                        'all_product',
                        'all_order_detail_status',
                        'status_order',
                        'payment_method',
                        'trans',
                        'all_voucher'
                    )
                );
                return $pdf->download('danhsachdonhang.pdf')->header('Content-Type', 'utf-8');
        }
    }

    public function filter_customer_follow_order_quantity_choose(Request $request)
    {
        $all_customer_db = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->get();
        $all_order = Orders::all();
        $order_quantity_option = $request->radioOrderQuantity;
        $type_filter = 'choose_quantity';
        $level_filter = $order_quantity_option;
        $quantity_start = 0;
        $quantity_end = 0;
        if ($order_quantity_option == 1) {
            $quantity_start = 0;
            $quantity_end = 20;
        } else if ($order_quantity_option == 2) {
            $quantity_start = 21;
            $quantity_end = 50;
        } else if ($order_quantity_option == 3) {
            $quantity_start = 51;
            $quantity_end = 100;
        } else if ($order_quantity_option == 4) {
            $quantity_start = 101;
            $quantity_end = 200;
        }
        $arrayCustomer = [];
        foreach ($all_customer_db as $customer) {
            $count_order = 0;
            foreach ($all_order as $order) {
                if ($customer->customer_id == $order->customer_id) {
                    $count_order++;
                }
            }
            if ($quantity_start <= $count_order && $count_order <= $quantity_end) {
                $customer->number_order = $count_order;
                $arrayCustomer[] = $customer;
            }
        }
        $all_customer = collect($arrayCustomer)->sortByDesc('number_order')->toArray();
        $string_title = 'Theo Số Lượng " Từ ' . $quantity_start . ' Đơn Hàng Đến ' . $quantity_end . ' Đơn Hàng"';
        echo view('admin.customer.view_filter_customer', compact(
            'type_filter',
            'level_filter',
            'all_order',
            'all_customer',
            'string_title'
        ));
    }

    public function filter_customer_follow_order_quantity_cus_option(Request $request)
    {
        $all_customer_db = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->get();
        $all_order = Orders::all();
        $type_filter = 'cus_quantity';
        $level_filter = '';
        $quantity_start = $request->quantityStart;
        $quantity_end = $request->quantityEnd;
        $arrayCustomer = [];
        foreach ($all_customer_db as $customer) {
            $count_order = 0;
            foreach ($all_order as $order) {
                if ($customer->customer_id == $order->customer_id) {
                    $count_order++;
                }
            }
            if ($quantity_start <= $count_order && $count_order <= $quantity_end) {
                $customer->number_order = $count_order;
                $arrayCustomer[] = $customer;
            }
        }
        $all_customer = collect($arrayCustomer)->sortByDesc('number_order')->toArray();
        $string_title = 'Theo Số Lượng " Từ ' . $quantity_start . ' Đơn Hàng Đến ' . $quantity_end . ' Đơn Hàng"';
        echo view('admin.customer.view_filter_customer', compact(
            'type_filter',
            'all_order',
            'level_filter',
            'all_customer',
            'string_title',
            'quantity_start',
            'quantity_end'
        ));
    }

    public function print_pdf_customer(Request $request)
    {
        $all_customer_db = DB::table('customer')
            ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
            ->get();
        $all_order = Orders::all();
        $all_transport = Customer_Transport::where('trans_status', 1)->get();
        $type_filter = $request->type_filter;
        $level_filter = $request->level_filter;


        switch ($type_filter) {
            case "choose_quantity":
                $quantity_start = 0;
                $quantity_end = 0;
                if ($level_filter == 1) {
                    $quantity_start = 0;
                    $quantity_end = 20;
                } else if ($level_filter == 2) {
                    $quantity_start = 21;
                    $quantity_end = 50;
                } else if ($level_filter == 3) {
                    $quantity_start = 51;
                    $quantity_end = 100;
                } else if ($level_filter == 4) {
                    $quantity_start = 101;
                    $quantity_end = 200;
                } else if ($level_filter == 5) {
                    $quantity_start = 200;
                }
                $arrayCustomer = [];
                foreach ($all_customer_db as $customer) {
                    $count_order = 0;
                    foreach ($all_order as $order) {
                        if ($customer->customer_id == $order->customer_id) {
                            $count_order++;
                        }
                    }
                    if ($quantity_start <= $count_order && $count_order <= $quantity_end) {
                        $arrayCustomer[] = $customer;
                    }
                }
                $all_customer = array_reverse($arrayCustomer);
                $string_title = 'Theo Số Lượng " Từ ' . $quantity_start . ' Đơn Hàng Đến ' . $quantity_end . ' Đơn Hàng"';
                $pdf = PDF::loadView(
                    'admin.customer.view_print_pdf_customer',
                    compact('all_order', 'all_customer', 'string_title', 'all_transport')
                );
                return $pdf->download('danhsachkhachhang.pdf');
                break;
            case "cus_quantity":
                $quantity_start = $request->quantity_start;
                $quantity_end = $request->quantity_end;

                $arrayCustomer = [];
                foreach ($all_customer_db as $customer) {
                    $count_order = 0;
                    foreach ($all_order as $order) {
                        if ($customer->customer_id == $order->customer_id) {
                            $count_order++;
                        }
                    }
                    if ($quantity_start <= $count_order && $count_order <= $quantity_end) {
                        $arrayCustomer[] = $customer;
                    }
                }
                $all_customer = array_reverse($arrayCustomer);
                $string_title = 'Theo Số Lượng " Từ ' . $quantity_start . ' Đơn Hàng Đến ' . $quantity_end . ' Đơn Hàng"';
                $pdf = PDF::loadView(
                    'admin.customer.view_print_pdf_customer',
                    compact('all_order', 'all_customer', 'string_title', 'all_transport')
                );
                return $pdf->download('danhsachkhachhang.pdf');
                echo $quantity_end . $quantity_start;

                break;
            default:
                $all_customer = DB::table('customer')
                    ->join('customer_info', 'customer_info.customer_id', '=', 'customer.customer_id')
                    ->get();
                $string_title = 'Danh Sách Khách Hàng';
                $pdf = PDF::loadView(
                    'admin.customer.view_print_pdf_customer',
                    compact('all_order', 'all_customer', 'string_title', 'all_transport')
                );
                return $pdf->download('danhsachkhachhang.pdf');
        }
    }
}
