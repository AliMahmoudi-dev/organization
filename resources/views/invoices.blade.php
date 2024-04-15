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

                                            <a @if (!$invoice->alreadyPaid()) href="{{ route('invoices.delete', $invoice->id) }}" @endif
                                                class="block text-center py-1 {{ !$invoice->alreadyPaid() ? 'bg-[#D73D42] text-white' : 'bg-[#E5E5E5] text-gray-400 cursor-context-menu' }} rounded">حذف
                                                درخواست</a>

                                            @can('confirm-invoices')
                                                <a href="{{ route('invoices.confirm', $invoice->id) }}"
                                                    class="block text-center py-1 {{ !$invoice->alreadyPaid() ? 'bg-[#0081FF] text-white' : 'bg-[#E5E5E5] text-gray-400 cursor-context-menu' }} rounded">
                                                    تایید کردن
                                                </a>
                                                <button data-url="{{ route('invoices.reject', $invoice->id) }}"
                                                    class="invoice-reject block text-center py-1 {{ !$invoice->alreadyPaid() ? 'bg-[#0081FF] text-white' : 'bg-[#E5E5E5] text-gray-400 cursor-context-menu' }} rounded">
                                                    رد کردن
                                                </button>
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
                        class="alert fixed top-4 right-10 bg-green-600 text-white font-semibold py-3 px-8 rounded-md">
                        پرداخت موفق</div>
                @else
                    <div class="alert fixed top-4 right-10 bg-red-500 text-white font-semibold py-3 px-8 rounded-md">
                        پرداخت ناموفق</div>
                @endif
            @endif

            <div id="reject" class="fixed inset-0 bg-black bg-opacity-45 hidden justify-center items-center">
                <div class="w-[500px] relative rounded-md overflow-hidden bg-white py-6">
                    <form action="" method="post">
                        @csrf
                        <label for="message" class="pr-12 py-2 block font-bold">علت رد درخواست</label>
                        <textarea class="w-[80%] block mx-auto border outline-none border-slate-400 rounded-md py-2 px-3.5" name="message"
                            id="message" rows="8"></textarea>
                        <input
                            class="border mt-3.5 outline-none cursor-pointer border-red-500 bg-red-500 py-2 px-3.5 font-bold text-white rounded w-[80%] mx-auto block"
                            type="submit" value="رد درخواست">
                    </form>
                    <div class="absolute top-2 left-2">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-layout>
