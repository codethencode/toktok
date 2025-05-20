<x-layout>
    <div class="max-w-7xl mx-auto px-6 md:px-12 xl:px-6">
        <div class="relative sm:pt-3 md:pt-36 ml-auto">
            <div class="lg:w-3/4 text-center mx-auto">
    <div x-data="clickableDivs()" class="space-y-4">
        <div x-on:click="toggleDiv1()" :class="{'bg-blue-500': div1 === 100, 'bg-gray-300': div1 === 50}"
             class="cursor-pointer p-6 text-white rounded-md">
            Div 1: <span x-text="div1"></span>
        </div>
        <div x-on:click="toggleDiv2()" :class="{'bg-red-500': div2 === 1000, 'bg-gray-300': div2 === 0}"
             class="cursor-pointer p-6 text-white rounded-md">
            Div 2: <span x-text="div2"></span>
        </div>
    </div>
            </div>
        </div>
    </div>

    </div>
    <script>
        function clickableDivs() {

            alert(localStorage.getItem('div1'));

            return {
                div1: localStorage.getItem('div1') ? parseInt(localStorage.getItem('div1')) : 50,
                div2: localStorage.getItem('div2') ? parseInt(localStorage.getItem('div2')) : 0,
                toggleDiv1() {
                    this.div1 = this.div1 === 50 ? 100 : 50;
                    localStorage.setItem('div1', this.div1);
                },
                toggleDiv2() {
                    this.div2 = this.div2 === 0 ? 1000 : 0;
                    localStorage.setItem('div2', this.div2);
                }
            }
        }
    </script>
</x-layout>
