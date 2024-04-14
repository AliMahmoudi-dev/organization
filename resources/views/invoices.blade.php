<x-layout>
    <div class="w-full min-h-full flex flex-col">
        <x-header />

        <div class="w-full relative py-10 flex flex-col flex-grow items-center">
            <div class="w-1/2">
                <div
                    class="w-full bg-gray-50 mb-2.5 border text-center border-gray-300 text-gray-800 text-lg font-bold px-3.5 py-2">
                    <span>لیست درخواست‌ها</span>
                </div>
                <div class="w-full text-black gap-x-4">
                    @if ($invoices->isNotEmpty())
                        @foreach ($invoices as $invoice)
                            <div class="border bg-gray-50 border-gray-300 mb-3.5">
                                @can('view-all-invoices')
                                    <div class="flex">
                                        <ul class="w-1/2 border-l border-b border-gray-300 px-4 py-2">
                                            <li class="text-sm text-gray-500 pb-1">نام و نام خانوادگی
                                            </li>
                                            <li>{{ $invoice->user->name }}</li>
                                        </ul>

                                        <ul class="w-1/2 px-4 py-2 border-b border-gray-300">
                                            <li class="text-sm text-gray-500 pb-1">کد ملی</li>
                                            <li>{{ $invoice->user->national_code }}</li>
                                        </ul>
                                    </div>

                                    <div class="flex">
                                        <ul class="w-1/2 border-l border-b border-gray-300 px-4 py-2">
                                            <li class="text-sm text-gray-500 pb-1">شماره موبایل
                                            </li>
                                            <li dir="ltr">{{ $invoice->user->phone_number }}</li>
                                        </ul>

                                        <ul class="w-1/2 px-4 py-2 border-b border-gray-300">
                                            <li class="text-sm text-gray-500 pb-1">ایمیل</li>
                                            <li>{{ $invoice->user->email }}</li>
                                        </ul>
                                    </div>
                                @endcan

                                <div class="flex">
                                    <ul class="w-1/2 border-l border-gray-300 px-4 py-2">
                                        <li class="text-sm text-gray-500 pb-1">مبلغ <span class="text-xs">(تومان)</span>
                                        </li>
                                        <li>{{ number_format($invoice->amount) }}</li>
                                    </ul>

                                    <ul class="w-1/2 px-4 py-2">
                                        <li class="text-sm text-gray-500 pb-1">بابت</li>
                                        <li>{{ $invoice->category->name }}</li>
                                    </ul>
                                </div>

                                <div class="flex">
                                    <ul class="w-1/2 border-l border-t border-gray-300 px-4 py-2">
                                        <li class="text-sm text-gray-500 pb-1">شماره شبا</li>
                                        <li>{{ $invoice->sheba_number }}</li>
                                    </ul>

                                    <ul class="w-1/2 border-t border-gray-300 px-4 py-2">
                                        <li class="text-sm text-gray-500 pb-1">وضعیت</span>
                                        </li>
                                        @switch($invoice->status)
                                            @case(-1)
                                                <li>رد شده</li>
                                            @break

                                            @case(0)
                                                <li>در انتظار تایید</li>
                                            @break

                                            @case(1)
                                                <li>تایید شده</li>
                                            @break

                                            @case(2)
                                                <li>پرداخت شده</li>
                                            @break
                                        @endswitch
                                    </ul>
                                </div>

                                <div>
                                    <ul class="w-full border-t border-gray-300 px-4 py-2">
                                        <li class="text-sm text-gray-500 pb-1">توضیحات</span>
                                        </li>
                                        <li>{{ $invoice->description ?? '-' }}</li>
                                    </ul>
                                </div>

                                <div>
                                    <ul class="w-full border-t border-gray-300 px-4 pt-2 pb-3">
                                        <li class="text-sm text-gray-500 pb-1">عملیات</span>
                                        </li>
                                        <li
                                            class="grid @can('confirm-invoices') grid-cols-5 @else grid-cols-3 @endcan gap-x-2">
                                            <a @if ($invoice->hasFile()) href="{{ route('invoices.download-file', $invoice->id) }}" @endif
                                                class="block text-center py-1 {{ $invoice->hasFile() ? 'bg-[#0081FF] text-white' : 'bg-[#E5E5E5] text-gray-400 cursor-context-menu' }} rounded">دانلود
                                                فایل
                                            </a>

                                            <a href="{{ route('invoices.delete', $invoice->id) }}"
                                                class="block text-center py-1 bg-[#D73D42] text-white rounded">حذف
                                                درخواست</a>

                                            @can('confirm-invoices')
                                                <a href="{{ route('invoices.confirm', $invoice->id) }}"
                                                    class="block text-center py-1 {{ !$invoice->alreadyPaid() ? 'bg-[#0081FF] text-white' : 'bg-[#E5E5E5] text-gray-400 cursor-context-menu' }} rounded">
                                                    تایید کردن
                                                </a>
                                                <a href="{{ route('invoices.reject', $invoice->id) }}"
                                                    class="block text-center py-1 {{ !$invoice->alreadyPaid() ? 'bg-[#0081FF] text-white' : 'bg-[#E5E5E5] text-gray-400 cursor-context-menu' }} rounded">
                                                    رد کردن
                                                </a>
                                            @endcan

                                            @if (!$invoice->isConfirmed() || $invoice->alreadyPaid())
                                                <a
                                                    class="block text-center py-1 bg-[#E5E5E5] text-gray-400 cursor-context-menu rounded">
                                                    پرداخت
                                                </a>
                                            @else
                                                <a href="{{ route('invoices.pay', $invoice->id) }}"
                                                    class="block text-center py-1 bg-[#0081FF] text-white rounded">
                                                    پرداخت
                                                </a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="border text-center py-2 border-gray-300">
                            هنوز درخواستی ثبت نکرده‌اید
                        </div>
                    @endif
                </div>
            </div>

            @if (!is_null(session('payment_status')))
                @if (session('payment_status'))
                    <div
                        class="alert absolute top-4 right-10 bg-green-600 text-white font-semibold py-3 px-8 rounded-md">
                        پرداخت موفق</div>
                @else
                    <div class="alert absolute top-4 right-10 bg-red-500 text-white font-semibold py-3 px-8 rounded-md">
                        پرداخت ناموفق</div>
                @endif
            @endif

        </div>
    </div>
</x-layout>
