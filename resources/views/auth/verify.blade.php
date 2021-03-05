<x-guest-layout>
    <!-- <x-auth-card> -->
    <x-slot name="logo">
        <a href="/">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </x-slot>

    <!-- Session Status -->
    <!-- <x-auth-session-status class="mb-4" :status="session('status')" /> -->

    <!-- Validation Errors -->
    <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> -->



    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="color:red">
            Verifying your data with TypingDNA
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                </div>
            </div>
        </div>
    </div> -->

    <section id="loading">
        <div class="content">
            Verifying your data with TypingDNA
        </div>
        <div id="loading-content"></div>

        <div class="content-footer">
            <form method="POST" action="/verifydna" name="form">
                @csrf

                <x-input type="hidden" class="block mt-1 w-full" name="typingPattern"
                    value="{{ session('typingPattern') }}" />

                <x-input type="hidden" class="block mt-1 w-full" name="textid" value="{{ session('textid') }}" />

                <x-input type="hidden" class="block mt-1 w-full" name="email" value="{{ session('email') }}" />
                <x-input type="hidden" class="block mt-1 w-full" name="password" value="{{ session('password') }}" />

                <x-button href="/" class="ml-3" id="sms">
                    {{ __('Send SMS') }}
                </x-button>

            </form>
            You will be redirected to the dashboard, if not click <a href="/dashboard">here</a>
        </div>
    </section>

    <!-- </x-auth-card> -->

    <x-slot name="script">
        <script>
            showLoading()

            function showLoading() {
                document.querySelector('#loading').classList.add('loading');
                document.querySelector('#loading-content').classList.add('loading-content');
            }

            function hideLoading() {
                document.querySelector('#loading').classList.remove('loading');
                document.querySelector('#loading-content').classList.remove('loading-content');
            }

            window.onload = function() {
                window.setTimeout(function() {
                    document.form.submit();
                }, 5000);
            };
        </script>
    </x-slot>


    <x-slot name="style">
        <style>
            .loading {
                z-index: 20;
                position: absolute;
                /* top: 0;
                left: 0; */
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.4);
            }

            .loading-content {
                border: 16px solid #f3f3f3;
                border-top: 16px solid #3498db;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                animation: spin 2s linear infinite;
                position: absolute;
                top: 50%;
                left: 46%;
                transform: translate(-50%, -50%);
            }

            .content {
                color: red;
                font-size: 20px;
                position: absolute;
                top: 40%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .content-footer {
                font-style: italic;
                font-size: 12px;
                position: absolute;
                top: 70%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .content-footer a {
                color: blue
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    </x-slot>
</x-guest-layout>