<x-app-layout>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-multiselect.css')}}" />

    <select id="example-getting-started" multiple="multiple">
        <option value="cheese">Cheese</option>
        <option value="tomatoes">Tomatoes</option>
        <option value="mozarella">Mozzarella</option>
        <option value="mushrooms">Mushrooms</option>
        <option value="pepperoni">Pepperoni</option>
        <option value="onions">Onions</option>
    </select>

    <script type="text/javascript" src="{{asset('assets/js/bootstrap-multiselect.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#example-getting-started').multiselect();
    });
    </script>
</x-app-layout>