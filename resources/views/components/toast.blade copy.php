@props([
    // Puedes pasar mensajes manuales si gustas, pero por defecto usa la sesión
    'messages' => [],
])

@php
    // Reúne mensajes desde la sesión (rol, success, status, warning, danger, error)
    $sessionMessages = collect([
        session('rol')     ? ['text' => session('rol'),     'type' => 'success'] : null,
        session('success') ? ['text' => session('success'), 'type' => 'success'] : null,
        session('status')  ? ['text' => session('status'),  'type' => 'info']    : null,
        session('warning') ? ['text' => session('warning'), 'type' => 'warning'] : null,
        session('danger')  ? ['text' => session('danger'),  'type' => 'error']   : null,
        session('error')   ? ['text' => session('error'),   'type' => 'error']   : null,
    ])->filter()->values();

    $items = collect($messages)->concat($sessionMessages)->values();
@endphp

@if($items->isNotEmpty())
<style>[x-cloak]{ display:none !important; }</style>
<div
    x-data="{
        toasts: {{ $items->toJson() }},
        remove(i){ this.toasts.splice(i,1) }
    }"
    class="pointer-events-none fixed inset-0 z-[9999] flex items-start justify-end p-4 sm:p-6"
    aria-live="polite" aria-atomic="true"
>
    <div class="flex w-full max-w-sm flex-col gap-2">
        <template x-for="(t, i) in toasts" :key="i">
            <div
                x-cloak
                x-init="setTimeout(() => remove(i), 6000)"
                x-show="true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="pointer-events-auto rounded-xl border p-3 shadow-lg backdrop-blur bg-white/85"
                :class="{
                    'border-green-200': t.type === 'success',
                    'border-blue-200':  t.type === 'info',
                    'border-yellow-200':t.type === 'warning',
                    'border-red-200':   t.type === 'error',
                }"
                role="status"
            >
                <div class="flex items-start gap-3">
                    <div class="mt-0.5">
                        <svg x-show="t.type==='success'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm-1 15-4-4 1.41-1.41L11 13.17l5.59-5.59L18 9Z"/></svg>
                        <svg x-show="t.type==='info'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600"  viewBox="0 0 24 24" fill="currentColor"><path d="M11 7h2v2h-2V7Zm0 4h2v6h-2v-6ZM12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Z"/></svg>
                        <svg x-show="t.type==='warning'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" viewBox="0 0 24 24" fill="currentColor"><path d="M1 21h22L12 2 1 21Zm12-3h-2v-2h2v2Zm0-4h-2v-4h2v4Z"/></svg>
                        <svg x-show="t.type==='error'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600"   viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm3.71 12.29-1.42 1.42L12 13.41l-2.29 2.3-1.42-1.42L10.59 12l-2.3-2.29 1.42-1.42L12 10.59l2.29-2.3 1.42 1.42L13.41 12l2.3 2.29Z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1 text-sm text-slate-800" x-text="t.text"></div>
                    <button type="button"
                        class="rounded-md p-1 text-slate-500 hover:text-slate-700"
                        x-on:click="remove(i)"
                        aria-label="Cerrar"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m13.41 12 4.3-4.29-1.42-1.42L12 10.59 7.71 6.29 6.29 7.71 10.59 12l-4.3 4.29 1.42 1.42L12 13.41l4.29 4.3 1.42-1.42Z"/></svg>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
@endif

