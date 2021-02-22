<template>
    <li class="nav-item" v-if="router && router.name">
      <router-link class="nav-link" :to="router" active-class="active" exact>
        <!-- <a href="#" class="nav-link"> -->
          <i :class="icon"></i> <span>{{ name }}</span>
          <span v-show="badge">
              <small class="label right" :class="[badge.type==='String'?'bg-green':'label-primary']">{{ badge.data }}</small>
          </span>
        <!-- </a> -->
      </router-link>
    </li>
    <li class="nav-item" :class="[getType, menuOpen ? 'menu-open' : '']" v-else>
        {{ isHeader ? name : '' }}
        <a href="#" class="nav-link" v-if="!isHeader" :class="menuOpen ? 'active' : ''" @click="setActive($event)">
            <i :class="icon"></i>
            <p>
                {{ name }}
                 <i class="right fa fa-angle-left"></i>
            </p>
            <span>
                <small v-if="badge && badge.data" class="label pull-right" :class="[badge.type==='String'?'bg-green':'label-primary']">{{ badge.data }}</small>
            </span>
        </a>
        <ul class="nav nav-treeview" v-if="items.length > 0">
            <template v-for="(item,index) in items">
              <template v-if="userPermissions.includes(item.permission)">
                <li class="nav-item" :key="index" v-if="item.router && item.router.name">
                  <router-link class="nav-link"
                      :data="item"
                      :to="item.router"
                      active-class="active" exact>
                          <i class="nav-icon" :class="item.icon"></i> {{ item.name }}
                  </router-link>
                </li>
                <li v-else :key="index" class="nav-item">
                    <a class="nav-link" v-if="item.link" :href="item.link" target="_blank">
                        <i class="nav-icon" :class="item.icon"></i> {{ item.name }}
                    </a>
                    <a class="nav-link" v-else>
                        <i class="nav-icon" :class="item.icon"></i> {{ item.name }}
                    </a>
                </li>
              </template>
            </template>
        </ul>
    </li>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
  name: 'menu-item',
  props: {
    type: {
      type: String,
      default: 'item'
    },
    isHeader: {
      type: Boolean,
      default: false
    },
    icon: {
      type: String,
      default: ''
    },
    name: {
      type: String
    },
    badge: {
      type: Object,
      default () {
        return {}
      }
    },
    items: {
      type: Array,
      default () {
        return []
      }
    },
    router: {
      type: Object,
      default () {
        return {
          name: ''
        }
      }
    },
    link: {
      type: String,
      default: ''
    }
  },
  created () {

  },
  data() {
      return {
          menuOpen: false
      }
  },
  computed: {
    getType () {
      if (this.isHeader) {
        return 'nav-header'
      }
      return this.type === 'item' ? '' : 'has-treeview'
    },
    ...mapGetters('auth', {
            user: 'user',
            userPermissions: 'userPermissions'
        })
  },
  methods: {
    setActive($event) {
      this.menuOpen = !this.menuOpen
    }
  },
  watch: {
    '$route'() {
      if (this.items) {
        this.items.find(item => item.router ? item.router.name == this.$route.name : null) ? this.menuOpen = true : this.menuOpen = false
      }
    }
  }
}
</script>
