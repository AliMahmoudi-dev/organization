<x-layout>
    <div class="w-full min-h-full flex flex-col">
        <x-header />

        <div class="w-full py-10 flex flex-col flex-grow items-center">
            <div class="w-1/2">
                <div
                    class="w-full bg-gray-50 mb-2.5 border text-center border-gray-300 text-gray-800 text-lg font-bold px-3.5 py-2">
                    <span>لیست درخواست‌ها</span>
                </div>
                <div class="w-full text-black gap-x-4">
                    @if ($invoices->isNotEmpty())
                        @foreach ($invoices as $invoice)
                            <div class="border bg-gray-50 border-gray-300 mb-3.5">
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
                                        <li>{{ $invoice->shaba_number }}</li>
                                    </ul>

                                    <ul class="w-1/2 border-t border-gray-300 px-4 py-2">
                                        <li class="text-sm text-gray-500 pb-1">وضعیت</span>
                                        </li>
                                        <li>{{ $invoice->status ? 'تایید شده' : 'در انتظار تایید' }}</li>
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
                                        <li class="grid grid-cols-3 gap-x-2">
                                            <a @if ($invoice->hasFile()) href="{{ route('invoices.download-file', $invoice->id) }}" @endif
                                                class="block text-center py-1 {{ $invoice->hasFile() ? 'bg-sky-600 text-white' : 'bg-[#E5E5E5] text-gray-400 cursor-context-menu' }} rounded">دانلود
                                                فایل
                                                ضمیمه شده</a>
                                            <a href="{{ route('invoices.delete', $invoice->id) }}"
                                                class="block text-center py-1 bg-[#D73D42] text-white rounded">حذف
                                                درخواست</a>
                                            <a href="http://"
                                                class="block text-center py-1 bg-emerald-600 text-white rounded">
                                                پرداخت
                                            </a>
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
        </div>
    </div>
</x-layout>
