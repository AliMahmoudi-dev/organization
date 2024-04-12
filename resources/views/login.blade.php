<x-layout>
    <div class="w-full min-h-full flex justify-center items-center">
        <div class="w-[450px] border border-gray-300 rounded-md overflow-hidden">
            <div class="bg-gray-100 border-b border-gray-300 text-gray-800 text-lg font-bold px-3.5 py-2">
                <span>ورود به سیستم</span>
            </div>

            @if ($errors->any())
                <div class="pt-4 px-3.5">
                    <ul
                        class="bg-rose-100 text-sm font-bold leading-6 py-2 rounded text-red-700 border border-red-200 px-2">
                        <li>{{ $errors->first() }}</li>
                    </ul>
                </div>
            @endif

            <div>
                <form action="{{ route('login.store') }}" method="post">
                    @csrf
                    <div class="grid gap-y-4 px-3.5 pt-4 pb-2.5">
                        <input class="border outline-none border-slate-400 rounded-md py-2 px-3.5" placeholder="کد ملی"
                            type="text" name="national_code" id="national_code" value="{{ old('national_code') }}">

                        <input class="border outline-none border-slate-400 rounded-md py-2 px-3.5" placeholder="گذرواژه"
                            type="password" name="password" id="password">

                        <div class="flex items-center gap-x-2 pr-1">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">مرا به خاطر بسپار</label>
                        </div>
                        <input
                            class="border outline-none cursor-pointer border-sky-600 bg-sky-600 py-2 px-3.5 text-lg font-bold text-white rounded-md"
                            type="submit" value="ورود">
                    </div>
                </form>
            </div>
            <div class="text-center line relative pb-2">
                <span class="text-gray-600">یا</span>
            </div>
            <div class="pb-5 px-4">
                <a class="block border border-gray-400 text-gray-700 text-center rounded-md py-2 px-3.5"
                    href="{{ route('register.create') }}">ثبت نام</a>
            </div>
        </div>
    </div>
</x-layout>
