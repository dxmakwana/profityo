<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn login_btn mb-3']) }}>
    {{ $slot }}
</button>
