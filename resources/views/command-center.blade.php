<x-layouts.app>

    @include('command-center.sections.dashboard')

    @include('command-center.sections.tasks-list')
    @include('command-center.sections.tasks-kanban')

    @include('command-center.sections.products-list')
    @include('command-center.sections.products-create')
    @include('command-center.sections.products-incomplete')
    @include('command-center.sections.products-review')
    @include('command-center.sections.products-ready')

    @include('command-center.sections.ai-product-content')
    @include('command-center.sections.ai-blog-content')
    @include('command-center.sections.ai-image-generation')
    @include('command-center.sections.ai-outputs')

    @include('command-center.sections.site-blog')
    @include('command-center.sections.site-cookbook')
    @include('command-center.sections.site-ideas')
    @include('command-center.sections.site-ready')

    @include('command-center.sections.sales-orders')
    @include('command-center.sections.sales-customers')
    @include('command-center.sections.sales-invoices')

    @include('command-center.sections.inventory-stock')
    @include('command-center.sections.inventory-suppliers')
    @include('command-center.sections.inventory-alerts')

    @include('command-center.sections.connections')

    @include('command-center.sections.activity-today')
    @include('command-center.sections.activity-changes')
    @include('command-center.sections.activity-errors')

    @include('command-center.sections.reports')

    @include('command-center.sections.settings-users')
    @include('command-center.sections.settings-roles')
    @include('command-center.sections.settings-brand')
    @include('command-center.sections.settings-theme')
    @include('command-center.sections.settings-system')

</x-layouts.app>
