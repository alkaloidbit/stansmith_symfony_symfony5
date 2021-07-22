<script>
export default {
    props: {
        listLength: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            selectedIndex: null,
        };
    },
    computed: {
        // selectedIndex: {
            // get() {
                // return this.$store.getters['currentIndex/currentIndex'];
            // },
            // set(newValue) {
                // this.$store.dispatch('currentIndex/setCurrentIndex', newValue);
            // },
        // },
    },
    created() {
        this.addKeyHandler();
    },
    destroyed() {
        this.removeKeyHandler();
    },
    methods: {
        keyHandler(e) {
            /**
                38 - up
                40 - down
                9 - tab
                13 - enter
            */
            const key = e.which || e.keyCode;

            if (key === 38 || (e.shiftKey && key === 9)) {
                this.handleKeyUp(e);
            } else if (key === 40 || key === 9) {
                this.handleKeyDown(e);
            } else if (key === 13) {
                this.handleEnter(e);
            }
        },
        handleEnter(e) {
            e.preventDefault();
            this.$emit('selected', this.selectedIndex);
        },
        handleKeyUp(e) {
            e.preventDefault();
            if (this.selectedIndex <= 0) {
                // If index is less than or equal to zero then set it to the last item index
                this.selectedIndex = this.listLength - 1;
            } else if (
                this.selectedIndex > 0
                && this.selectedIndex <= this.listLength - 1
            ) {
                // If index is larger than zero and smaller or equal to last index then decrement
                this.selectedIndex -= 1;
            }
        },

        handleKeyDown(e) {
            e.preventDefault();
            // check if index is below 0
            // this means that we did not start yet
            if (
                this.selectedIndex < 0
                || this.selectedIndex === this.listLength - 1
            ) {
                // set the index to the first item
                this.selectedIndex = 0;
            } else if (
                this.selectedIndex >= 0
                && this.selectedIndex < this.listLength - 1
            ) {
                this.selectedIndex += 1;
                console.log('this.selectedIndex', this.selectedIndex);
            }
        },
        addKeyHandler(e) {
            window.addEventListener('keydown', this.keyHandler);
        },

        removeKeyHandler() {
            window.removeEventListener('keydown', this.keyHandler);
        },
    },
    render(h) {
        return h(
            'div',
            this.$scopedSlots.default({ selectedIndex: this.selectedIndex }),
        );
    },
};
</script>
