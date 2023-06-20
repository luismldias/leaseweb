<template>
    <div id="loading-overlay" v-if="isLoading">
        <div class="loading-spinner"></div>
    </div>
    <h1> Server's are US </h1>
    <div id="mainContainer">
        <div id="filtersContainer">
            <div class="filterContainer" id="locationFilterContainer">
                <label >Location : </label>
                <select name="location" v-model="selectedLocation" >
                    <option v-for="location in locations" :value="location.id">
                        {{ location.name }}
                    </option>
                </select>
            </div>
            <div class="filterContainer" id="hddFilterContainer">
                <label >HDD Type : </label>
                <select name="hdd" v-model="selectedHdd" >
                    <option value="" selected>Select a HDD type</option>
                    <option v-for="hddType in hddTypes" :value="hddType">
                        {{ hddType }}
                    </option>
                </select>
            </div>
            <div class="filterContainer" id="ramFilterContainer">
                <label >RAM : </label>
                <span v-for="ramValue in ramValues"> 
                    <input type="checkbox" :value="ramValue" v-model="selectedRam">
                    {{ ramValue }}Gb
                </span>
            </div>
            <div class="filterContainer" id="hddFilterContainer">
                <select name="hdd" v-model="selectedHdd">
                    <option value="" selected>Select a HDD type</option>
                    <option v-for="hddType in hddTypes" :value="hddType">
                        {{ hddType }}
                    </option>
                </select>
            </div>

            <div class="filterContainer" id="hddFilterContainer">
                <label >HDD Size : </label>
                <br>
                <input type="range" min="0" step="1" v-model="hddSliderValue" max="11" class="slider" />
                {{ selectedHddLabel }} 
            </div>
        </div>    
        <input type="button" value="Search" @click="getList">&nbsp;
        <input type="button" value="Reset Filters" @click="resetFilters">
        <hr>

        <div id="listContainer">
            <table class="full-width-table">
                <thead>
                    <tr>
                    <th>Model</th>
                    <th>Ram</th>
                    <th>Hdd</th>
                    <th>Location</th>
                    <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in listItems" :key="item.id">
                    <td>{{ item.model }}</td>
                    <td>{{ item.ram }}</td>
                    <td>{{ item.hdd }}</td>
                    <td>{{ item.location }}</td>
                    <td>{{ item.price }}</td>
                    </tr>
                </tbody>
                </table>
            
        </div>
        <pagination v-model="currentPage" :records="totalItems" :per-page="20" @paginate="onPaginate"/>
    </div>
    
   

</template>
<script>


import axios from 'axios'
import { reactive, computed, onMounted, ref } from 'vue'
import Pagination from 'v-pagination-3';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';

export default {

    name: 'ServersList',
    components: {Pagination},
    setup() {

        const isLoading   = ref(false) 
        const locations     = ref()
        const hddTypes     = ref()
        const ramValues     = ref()
        const listItems = ref([])
        const initialItems = ref([])
        const pagingInfo = ref()
        const selectedLocation = ref(0)
        const selectedHdd = ref('')
        const selectedRam = ref([])
        const selectedHddSize = ref(0) 
        const hddSliderValue = ref(0) 
        const possibleHddSizes = ref([])
        const currentPage = ref(1)
        const totalPages = ref(0) 
        const totalItems = ref(0) 
        

        const selectedHddLabel = computed(() => {
            
            if (hddSliderValue.value == "0" ){
                return 'All';
            }
            
            selectedHddSize.value = possibleHddSizes.value[hddSliderValue.value].value
            return possibleHddSizes.value[hddSliderValue.value].label

        })

        onMounted(() => {
            getStructure()
            getList()
        })

        const onPaginate = async (page) => {
            getList(page);
        }

        const resetFilters = async () => {
            selectedLocation.value = 0;
            selectedHdd.value = ''
            selectedRam.value = []
            selectedHddSize.value = 0
            currentPage.value = 1
            getList();
        }



        const getList = async (page) => {
            isLoading.value = true
            try {

                let params = {};
                params.filter = {};
                params.paging = {};

                if (selectedLocation.value > 0){
                    params.filter.location_id = selectedLocation.value; 
                }
                if (selectedHdd.value !==''){
                    params.filter.hdd_type = selectedHdd.value; 
                }
                if (selectedRam.value.length !== 0){
                    params.filter.ram = selectedRam.value; 
                }

                if (selectedHddSize.value !== 0){
                    params.filter.storage_to = selectedHddSize.value; 
                }

                if (page > 0){
                    params.paging.page = page; 
                }

                                
                const req = await axios.get('/api/servers', {params})
                listItems.value  = req.data.data
                pagingInfo.value = req.data.pagination
                totalPages.value = req.data.pagination.total_pages;
                totalItems.value = req.data.pagination.total_items;
                

               
                console.log(req.data.pagination,pagingInfo)
                //console.log(req.data)
            } catch (e) {
                console.log('Error:', e)
            }finally {
                if (isLoading.value){
                    isLoading.value = false
                }
            }
        }



        const getStructure = async () => {
            isLoading.value = true
            try {
                const req = await axios.get('/api/structure')
                locations.value = req.data.data.filters.locations
                hddTypes.value = req.data.data.filters.hdd_types
                ramValues.value = req.data.data.filters.ram
                possibleHddSizes.value = req.data.data.filters.hdd_sizes
            } catch (e) {
                    console.log('Error:', e)
            }finally {
                if (isLoading.value){
                    isLoading.value = false
                }
            }
        }

        return {
            isLoading, 
            locations,
            hddTypes,
            listItems,
            pagingInfo,
            selectedLocation,
            selectedHdd,
            ramValues,
            selectedRam,
            getList,
            selectedHddSize,
            possibleHddSizes,
            hddSliderValue,
            selectedHddLabel,
            currentPage,
            onPaginate,
            totalPages,
            totalItems,
            resetFilters
        }

   }
}
</script>