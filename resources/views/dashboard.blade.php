<x-master  title="Dashboard">
<x-top-bar/>
<div class="row">
    <x-dashboard-card title="Users" :count="$userCount" color="primary" />
    <x-dashboard-card title="Categories" :count="$categoryCount" color="primary" />
</div>
</x-master>
