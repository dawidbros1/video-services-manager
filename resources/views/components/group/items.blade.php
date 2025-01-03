<div class="flex flex-wrap">
    @foreach ($groups as $group)
        <x-group.item :details="$group" editable="0" />
    @endforeach
</div>

<x-group.form
    id="update_group"
    title="Edycja grupy"
    open=".update_group"
    route="groups.update"
/>

<script>
    $(document).ready(function() {
        const form = $('form#update_group');

     
        $('.group').each(function() {
            const self = $(this);
        
            // EDYCJA GRUPY
            $(this).find('.update_group').on('click', function() {
                ['id', 'name', 'thumb'].forEach(name => {
                    $(form).find('input[name="'+name+'"]').val($(self).data(name));
                });
            })

            // KASOWANIE GRUPY
            $(this).find('.delete_group').on('click', function() {
                $(this).parent('form').find('button').click();
            });
        });
    });
</script>