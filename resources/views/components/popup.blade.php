<div id = "popup_{{$id}}" class="popup">
    <!-- Tło z rozmyciem -->
    <div class="backdrop" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(5px); z-index: 10;"></div>

    <!-- Formularz -->
    <div class="popup-content" style="display: none; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background: white; border: 2px solid black; border-radius: 8px; padding: 20px; width: 400px; z-index: 20;">
        <h2 style="text-align: center; margin-bottom: 20px; font-size: 24px">{{ $title }}</h2>
        
        <div>
            {{ $slot }}
        </div>
    </div>
</div>

<script>
    $('{{$open}}').on('click', function() {
        $('#popup_{{$id}} .popup-content').show();
        $('#popup_{{$id}} .backdrop').show();
    });

    // dodać zamklnięcie z poziomu popup
</script>
