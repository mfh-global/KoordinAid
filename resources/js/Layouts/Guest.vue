<template>
    <div class="h-16 bg-slate-800 py-2 px-4 shadow-lg">
        <div class="flex justify-between">
            <div class="flex items-center space-x-4">
                <img class="h-12" src="/logo-hermine.png" alt="Hermine Logo." />
                <h1 class="text-slate-100 text-2xl">Needlist</h1>
            </div>
        </div>
        <div class="mx-auto max-w-7xl my-16">
            <slot />
        </div>
    </div>
</template>
