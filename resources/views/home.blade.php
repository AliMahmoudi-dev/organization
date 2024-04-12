<x-layout>
    <div class="w-full min-h-full flex flex-col">
        <x-header />

        <div class="w-full flex flex-col flex-grow items-center pt-10">
            <div class="w-1/2">
                <div
                    class="w-full bg-gray-100 border-x border-t border-gray-300 text-gray-800 text-lg font-bold px-3.5 py-2">
                    <span>مشخصات کاربری</span>
                </div>
                <div class="w-full text-black table border border-collapse gap-x-4 ">
                    <div class="table-row-group">
                        <div class="table-row border border-gray-300">
                            <ul class="table-cell border border-gray-300 px-4 py-2">
                                <li class="text-sm text-gray-500 pb-1">نام و نام خانوادگی</li>
                                <li>{{ $user->name }}</li>
                            </ul>

                            <ul class="table-cell border border-gray-300 px-4 py-2">
                                <li class="text-sm text-gray-500 pb-1">کد ملی</li>
                                <li>{{ $user->national_code }}</li>
                            </ul>
                        </div>
                        <div class="table-row border border-gray-300">
                            <ul class="table-cell border border-gray-300 px-4 py-2">
                                <li class="text-sm text-gray-500 pb-1">شماره موبایل</li>
                                <li>{{ $user->phone_number }}</li>
                            </ul>

                            <ul class="table-cell border border-gray-300 px-4 py-2">
                                <li class="text-sm text-gray-500 pb-1">ایمیل</li>
                                <li>{{ $user->email }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
