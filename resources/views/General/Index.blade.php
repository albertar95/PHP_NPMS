@extends('Layouts.app')

@section('Content')
@endsection

@section('scripts')
<script type="text/javascript">
$(function()
{
    let refer = document.referrer;
    if(refer.includes('login'))
    {
        $('#EnteranceModal').modal('show');
    }
});
</script>
@endsection
