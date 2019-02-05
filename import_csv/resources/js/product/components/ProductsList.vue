<template>
    <section class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <form class="form-inline form-search" v-on:submit.prevent="search()">
                        <input class="form-control" type="search" placeholder="Wyszukaj po kodzie produktu" v-model="mpn">
                        <button class="btn btn-outline-success" type="submit">Wyszukaj</button>
                    </form>
                </div>
            </div>

            <nav v-if="showPagination">
                <ul class="pagination">
                    <li class="page-item" v-if="currentPage > 0">
                        <button class="page-link" :disabled="disabledButton" @click="prevPage()">
                            <span>&laquo;</span>
                        </button>
                    </li>
                    <li class="page-item" v-if="currentPage < pages">
                        <button class="page-link" :disabled="disabledButton" @click="nextPage()">
                            <span>&raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kod produktu</th>
                        <th>Ilość</th>
                        <th>Rok produkcji</th>
                        <th>Cena</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products" :key="product.id">
                        <th>{{ (index + 1) + (currentPage * productsPerPage) }}</th>
                        <td>{{ product.mpn }}</td>
                        <td>{{ product.quantity }}</td>
                        <td>{{ product.production_year }}</td>
                        <td>{{ product.price }}</td>
                    </tr>
                </tbody>
            </table>

            <nav v-if="showPagination">
                <ul class="pagination">
                    <li class="page-item" v-if="currentPage > 0">
                        <button class="page-link" :disabled="disabledButton" @click="prevPage()">
                            <span>&laquo;</span>
                        </button>
                    </li>
                    <li class="page-item" v-if="currentPage < pages">
                        <button class="page-link" :disabled="disabledButton" @click="nextPage()">
                            <span>&raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</template>

<script>
    export default {
        data () {
            return {
                productsPerPage: 100,
                mpn: null,
                products: null,
                pages: null,
                currentPage: 0,
                showPagination: false,
                disabledButton: false
            }
        },
        created() {
            this.fetchProducts(0, this.productsPerPage)
        },
        methods: {
            search() {
                this.currentPage = 0
                this.fetchProducts(0, this.productsPerPage)
            },
            nextPage() {
                this.disabledButton = true
                this.currentPage++;
                this.fetchProducts(this.currentPage * this.productsPerPage, this.productsPerPage)
            },
            prevPage() {
                this.disabledButton = true
                this.currentPage--;
                this.fetchProducts(this.currentPage * this.productsPerPage, this.productsPerPage)
            },
            fetchProducts(offset, limit) {
                axios.get('/api/products', {
                    params: {
                        'offset': offset,
                        'limit': limit,
                        'mpn': this.mpn
                    }
                })
                .then((response) => {
                    this.showPagination = false
                    this.products = response.data.products
                    this.pages = Math.ceil(response.data.products_count / this.productsPerPage) - 1
                    this.showPagination = true
                    this.disabledButton = false
                })
                .catch((error) => {
                    console.log(error)
                })
            } 
        }
    }
</script>
