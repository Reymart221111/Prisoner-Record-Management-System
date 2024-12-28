{ 
    status: '',
    securityLevel: '',
    showStatusNote: false,
    statusBadgeColor: '',
    photoPreview: null,
    formClass: 'p-8 space-y-12 transition-all duration-300',

    initForm() {
        this.$watch('status', value => {
            this.showStatusNote = ['released', 'escaped', 'deceased', 'transferred'].includes(value);
            this.updateStatusBadgeColor();
        });

        this.$watch('securityLevel', value => {
            this.updateFormAppearance();
        });
    },

    updateStatusBadgeColor() {
        const colors = {
            'active': 'bg-green-100 text-green-800',
            'released': 'bg-blue-100 text-blue-800',
            'transferred': 'bg-yellow-100 text-yellow-800',
            'deceased': 'bg-gray-100 text-gray-800',
            'escaped': 'bg-red-100 text-red-800'
        };
        this.statusBadgeColor = colors[this.status] || '';
    },

    updateFormAppearance() {
        const baseClasses = 'p-8 space-y-12 transition-all duration-300';
        const securityColors = {
            'minimum': 'border-2 border-green-200',
            'medium': 'border-2 border-yellow-200',
            'maximum': 'border-2 border-orange-200',
            'supermax': 'border-2 border-red-200'
        };
        this.formClass = this.securityLevel ? 
            `${baseClasses} ${securityColors[this.securityLevel]}` : 
            baseClasses;
    },

}