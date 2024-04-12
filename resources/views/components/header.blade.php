<div>
    <div class="bg-[#262728] text-white flex justify-between px-20">
        <div>
            <ul class="flex">
                <li>
                    <a class="py-4 px-2.5 block hover:bg-rose-400" href="{{ route('home') }}">مشخصات</a>
                </li>
                <li>
                    <a class="py-4 px-2.5 block hover:bg-rose-400" href="{{ route('invoices.index') }}">لیست
                        درخواست‌ها</a>
                </li>
                <li>
                    <a class="py-4 px-2.5 block hover:bg-rose-400" href="{{ route('invoices.create') }}">ثبت درخواست</a>
                </li>
            </ul>
        </div>
        <div>
            <a class="py-4 flex items-center justify-center gap-x-1.5 px-6 hover:bg-rose-400" href="{{ route('logout') }}">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.8"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
                    </svg>
                </span>
                <span>خروج</span>
            </a>
        </div>
    </div>
</div>
