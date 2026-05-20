document.addEventListener('alpine:init', () => {
    Alpine.data('categoryUi', () => ({
        formOpen: false,
        confirmOpen: false,
        formMode: 'create',
        formAction: '',
        formMethod: 'POST',
        formTitle: 'Add Category',
        formSubmitLabel: 'Save',
        confirmTitle: 'Confirm Deletion',
        confirmMessage: '',
        confirmAction: '',
        confirmMethod: 'POST',
        fieldErrors: {},
        formData: {
            id: null,
            name: '',
            description: '',
        },

        openCreate(createUrl) {
            this.resetForm();
            this.formMode = 'create';
            this.formAction = createUrl;
            this.formMethod = 'POST';
            this.formTitle = 'Add Category';
            this.formSubmitLabel = 'Create Category';
            this.formOpen = true;
        },

        openEdit(editUrl, category) {
            this.resetForm();
            this.formMode = 'edit';
            this.formAction = editUrl;
            this.formMethod = 'PUT';
            this.formTitle = 'Edit Category';
            this.formSubmitLabel = 'Update';
            this.formData = {
                id: category.id,
                name: category.name ?? '',
                description: category.description ?? '',
            };
            this.formOpen = true;
        },

        openConfirm({ title, message, action, method = 'POST' }) {
            this.confirmTitle = title ?? 'Confirm';
            this.confirmMessage = message ?? 'Are you sure?';
            this.confirmAction = action;
            this.confirmMethod = method;
            this.confirmOpen = true;
        },

        openDeleteConfirm(deleteUrl, categoryName) {
            this.openConfirm({
                title: 'Delete Category',
                message: `Are you sure you want to delete "${categoryName}"? This action is irreversible.`,
                action: deleteUrl,
                method: 'DELETE',
            });
        },

        closeForm() {
            this.formOpen = false;
            this.fieldErrors = {};
        },

        closeConfirm() {
            this.confirmOpen = false;
        },

        resetForm() {
            this.fieldErrors = {};
            this.formData = {
                id: null,
                name: '',
                description: '',
            };
        },

        async submitForm() {
            const form = this.$refs.entityForm;
            if (!form) return;

            const body = new FormData(form);
            if (this.formMethod !== 'POST') {
                body.append('_method', this.formMethod);
            }

            try {
                const response = await fetch(this.formAction, {
                    method: 'POST',
                    body,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                });

                const data = await response.json().catch(() => ({}));

                if (response.ok) {
                    window.location.reload();
                    return;
                }

                if (response.status === 422) {
                    this.fieldErrors = data.errors ?? {};
                    return;
                }

                alert(data.message ?? 'An error occurred.');
            } catch {
                alert('Unable to reach the server.');
            }
        },

        async submitConfirm() {
            const body = new FormData();
            body.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ?? '');
            if (this.confirmMethod !== 'GET' && this.confirmMethod !== 'POST') {
                body.append('_method', this.confirmMethod);
            }

            try {
                const response = await fetch(this.confirmAction, {
                    method: 'POST',
                    body,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    },
                });

                const data = await response.json().catch(() => ({}));

                if (response.ok) {
                    window.location.reload();
                    return;
                }

                alert(data.message ?? 'An error occurred.');
            } catch {
                alert('Unable to reach the server.');
            }
        },

        errorFor(field) {
            const messages = this.fieldErrors[field];
            return messages?.[0] ?? null;
        },
    }));
});
