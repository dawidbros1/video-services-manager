<x-popup title="{{$title}}" open="{{$open}}" id={{$id}}>
   <form id = {{$id}} action="{{ route($route) }}" method="POST">
        @csrf <!-- Token CSRF -->

        <input type = "hidden" name = "id" value = "" />

        <div style="margin-bottom: 15px;">
            <label for="group-name" style="display: block;">Nazwa grupy:</label>
            <input type="text" name="name" id="group-name" placeholder="Wpisz nazwę grupy" style="width: 100%; padding: 8px; border: 1px solid gray; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label for="group-thumb" style="display: block;">Miniaturka grupy:</label>
            <input type="text" name="thumb" id="group-thumb" placeholder="URL miniaturki" style="width: 100%; padding: 8px; border: 1px solid gray; border-radius: 4px;">
        </div>

        <div style="text-align: center;">
            <button type="submit" style="padding: 10px 20px; background: #4caf50; color: white; border: none; border-radius: 4px; cursor: pointer;">Zatwierdź</button>
            <button type="button" class="close-form" style="padding: 10px 20px; background: gray; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">Zamknij</button>
        </div>
   </form>
</x-popup>

<script>
    $(document).ready(function() {
        const form = $('form#{{$id}}');

        $(form).find('.close-form').on('click', function() {
            $(form).parents('.popup').find('.popup-content').hide();
            $(form).parents('.popup').find('.backdrop').hide();
        });
    });
</script>
