<template>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right" v-if="breadcrumbList">
                            <li v-for="(b, i) in breadcrumbList"
                                :key="i" class="breadcrumb-item"
                                @click="routeTo(i)"
                                :class="b.link ? '' : 'active'">
                                {{b.name}}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- <ContentHeader /> -->
        <section class="content">
            <div class="container-fluid">
                <slot></slot>
            </div>
        </section>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data () {
        return {
        //   breadcrumbList: [],
        }
    },
    computed: {
        ...mapGetters(['breadcrumbList'])
    },
    methods: {
        routeTo (pRouteTo) {
            if(this.breadcrumbList[pRouteTo].link)
                this.$router.push(this.breadcrumbList[pRouteTo].link)
        },
        // updateList () {
        //     this.breadcrumbList = this.$route.meta.breadcrumb
        // }
    },
    // watch: {
    //     '$route' () {
    //         this.breadcrumbList = this.$route.meta.breadcrumb
    //     }
    // },
    mounted() {
        // this.updateList()
    }    
}
</script>

<style scoped>
    li {
        cursor: pointer;
    }

    .content-wrapper {
        min-height: 1200.88px;
    }
</style>
