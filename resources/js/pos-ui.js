document.addEventListener('alpine:init', () => {
    Alpine.data('posUi', () => ({
        formOpen: false,
        confirmOpen: false,
        formMode: 'create',
        formAction: '',
        formMethod: 'POST',
        formTitle: 'Ajouter un produit',
        formSubmitLabel: 'Enregistrer',
        confirmTitle: 'Confirmer la suppression',
        confirmMessage: '',
        confirmAction: '',
        confirmMethod: 'POST',
        fieldErrors: {},
        formData: {
            id: null,
            name: '',
            price: '',
            quantity_stock: '',
            description: '',
            category_id: '',
            supplier_id: '',
        },

        openCreate(createUrl) {
            this.resetForm();
            this.formMode = 'create';
            this.formAction = createUrl;
            this.formMethod = 'POST';
            this.formTitle = 'Ajouter un produit';
            this.formSubmitLabel = 'Créer le produit';
            this.formOpen = true;
        },

        openEdit(editUrl, product) {
            this.resetForm();
            this.formMode = 'edit';
            this.formAction = editUrl;
            this.formMethod = 'PUT';
            this.formTitle = 'Modifier le produit';
            this.formSubmitLabel = 'Mettre à jour';
            this.formData = {
                id: product.id,
                name: product.name ?? '',
                price: product.price ?? '',
                quantity_stock: product.quantity_stock ?? '',
                description: product.description ?? '',
                category_id: product.category_id ? String(product.category_id) : '',
                supplier_id: product.supplier_id ? String(product.supplier_id) : '',
            };
            this.formOpen = true;
        },

        openConfirm({ title, message, action, method = 'POST' }) {
            this.confirmTitle = title ?? 'Confirmer';
            this.confirmMessage = message ?? 'Êtes-vous sûr ?';
            this.confirmAction = action;
            this.confirmMethod = method;
            this.confirmOpen = true;
        },

        openDeleteConfirm(deleteUrl, productName) {
            this.openConfirm({
                title: 'Supprimer le produit',
                message: `Voulez-vous vraiment supprimer « ${productName} » ? Cette action est irréversible.`,
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
                price: '',
                quantity_stock: '',
                description: '',
                category_id: '',
                supplier_id: '',
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

                alert(data.message ?? 'Une erreur est survenue.');
            } catch {
                alert('Impossible de contacter le serveur.');
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

                alert(data.message ?? 'Une erreur est survenue.');
            } catch {
                alert('Impossible de contacter le serveur.');
            }
        },

        errorFor(field) {
            const messages = this.fieldErrors[field];
            return messages?.[0] ?? null;
        },
    }));
});
