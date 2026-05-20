<!DOCTYPE html>
<html class="light" lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <title>{{ $title ?? 'Inventory Manager' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/styles/choices.min.css">
<script src="https://cdn.jsdelivr.net/npm/choices.js@11.1.0/public/assets/scripts/choices.min.js"></script>
</head>

<body class="bg-background text-on-surface font-body-md overflow-x-hidden"
      x-data="posUi()">

<script>
document.addEventListener('alpine:init', () => {

    Alpine.store('crud', {

        formOpen: false,
        confirmOpen: false,

        mode: 'create',
        action: '',
        formData: {},

        confirmTitle: '',
        confirmMessage: '',
        confirmCallback: null,

        openCreate(action, initialData = {}) {
            this.mode = 'create'
            this.action = action
            this.formData = initialData

            this.formOpen = true
        },

        openEdit(action, data) {
            this.mode = 'edit'
            this.action = action
            this.formData = { ...data }

            this.formOpen = true
        },

        closeForm() {
            this.formOpen = false
        },

        openConfirm(title, message, action) {
            this.confirmTitle = title;
            this.confirmMessage = message;
            this.confirmAction = action;
            this.confirmOpen = true;
        },

        closeConfirm() {
            this.confirmOpen = false;
            this.confirmTitle = '';
            this.confirmMessage = '';
            this.confirmAction = null;
        },

        submitConfirm() {
            if (typeof this.confirmAction === 'function') {
                this.confirmAction();
            }
            this.closeConfirm();
        }

    })

})
</script>

@include('partials.sidebar')
@include('partials.topbar')

@yield('page')
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll("select").forEach((el) => {

        new Choices(el, {
            searchEnabled: true,
            shouldSort: false,
            itemSelectText: "",
        });

    });

});
</script>
</body>
</html>