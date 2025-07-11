<!-- Header -->
<header class="bg-blue-100 px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold text-black"></h1>
    <div class="flex items-center gap-2 text-lg font-semibold text-black">
        {{ Auth::user()->name ?? Auth::user()->username }}
        <span class="material-icons">account_circle</span>
    </div>
</header>
