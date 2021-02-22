export default {
    data() {
        return {
            errors: []
        }
    },
    methods: {
        makeErrorToast() {
            Object.values(this.errors).forEach((value) => {
                value.map(message => {
                    this.$bvToast.toast(message, {
                        title: `Atenção`,
                        variant: 'danger',
                        solid: true,
                        autoHideDelay: 15000,
                    })
                })
            })
        },
        toastSuccess(message, time = 5000) {
            this.$bvToast.toast(message, {
                title: `Atenção`,
                variant: 'success',
                solid: true,
                autoHideDelay: time,
            })
        },
        toastDanger(message, time = 15000) {
            this.$bvToast.toast(message, {
                title: `Atenção`,
                variant: 'danger',
                solid: true,
                autoHideDelay: time,
            })
        },
        toastInfo(message, time = 15000) {
            this.$bvToast.toast(message, {
                title: `Atenção`,
                variant: 'info',
                solid: true,
                autoHideDelay: time,
            })
        },
    },
    watch: {
        errors: {
            handler: 'makeErrorToast'
        }
    },
}