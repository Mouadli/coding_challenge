<template>
  <div class="container" :class="{ loading: loading }">
    <!-- Button trigger modal -->
    <button
      type="button"
      class="btn btn-success btn-sm float-right mt-2"
      data-toggle="modal"
      data-target="#exampleModal"
    >
      New Product
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input
              type="text"
              :class="['form-control my-2', errors.name ? 'is-invalid' : '']"
              placeholder="Name"
              v-model="product.name"
            />
            <span v-if="errors.name" class="p-1 bg-danger text-white rounded">{{
              errors.name[0]
            }}</span>
            <textarea
              :class="[
                'form-control my-2',
                errors.description ? 'is-invalid' : '',
              ]"
              placeholder="Description"
              v-model="product.description"
            ></textarea>
            <span
              v-if="errors.description"
              class="p-1 bg-danger text-white rounded"
              >{{ errors.description[0] }}</span
            >
            <input
              type="text"
              :class="['form-control my-2', errors.price ? 'is-invalid' : '']"
              placeholder="Price"
              v-model="product.price"
            />
            <span
              v-if="errors.price"
              class="p-1 bg-danger text-white rounded"
              >{{ errors.price[0] }}</span
            >
            <div class="form-group">
              <b-form-select
                v-model="product.category"
                :options="categoryOptions"
              >
                <template #first>
                  <b-form-select-option :value="null" disabled
                    >-- Please select a category --</b-form-select-option
                  >
                </template>
              </b-form-select>
            </div>
            <span
              v-if="errors.category_id"
              class="p-1 bg-danger text-white rounded"
              >{{ errors.category_id[0] }}</span
            >
            <div>
              <label for="image">Image</label>
              <input
                type="file"
                class="form-control"
                name="image"
                @change="onImageHandler"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              Close
            </button>
            <button
              type="button"
              class="btn btn-success"
              @click="createProduct"
            >
              Create
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 mb-4">
        <h1 class="mt-4">Filters</h1>

        <input
          type="text"
          placeholder="search..."
          v-model="search"
          class="form-control"
        />

        <h3 class="mt-2">Price</h3>
        <div class="form-check" v-for="(price, index) in prices">
          <input
            class="form-check-input"
            type="checkbox"
            :value="index"
            :id="'price' + index"
            v-model="selected.prices"
          />
          <label class="form-check-label" :for="'price' + index">
            {{ price.name }} ({{ price.products_count }})
          </label>
        </div>

        <h3 class="mt-2">Categories</h3>
        <div class="form-check" v-for="(category, index) in categories">
          <input
            class="form-check-input"
            type="checkbox"
            :value="category.id"
            :id="'category' + index"
            v-model="selected.categories"
          />
          <label class="form-check-label" :for="'category' + index">
            {{ category.name }} ({{ category.products_count }})
          </label>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="row mt-4">
          <div class="col-lg-4 col-md-6 mb-4" v-for="product in products">
            <div class="card h-100">
              <a href="#">
                <img
                  class="card-img-top"
                  src="http://placehold.it/700x400"
                  alt=""
                />
              </a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#">{{ product.name }}</a>
                </h4>
                <h5>$ {{ product.price }}</h5>
                <p class="card-text">{{ product.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      product: {
        id: "",
        name: "",
        description: "",
        price: "",
        category: "",
        image: "",
      },
      categoryOptions: [],
      errors: {},
      search: "",
      prices: [],
      categories: [],
      products: [],
      loading: true,
      selected: {
        prices: [],
        categories: [],
      },
    };
  },

  mounted() {
    this.loadCategories();
    this.loadPrices();
    this.loadProducts();
    this.getCategories();
  },

  watch: {
    search: function () {
      this.searchdata(this.search);
    },
    selected: {
      handler: function () {
        this.loadCategories();
        this.loadPrices();
        this.loadProducts();
      },
      deep: true,
    },
  },

  methods: {
    getCategories: function () {
      axios.get("api/getCategories").then((res) => {
        for (var i = 0; i < res.data.categories.length; i++) {
          this.categoryOptions.push({
            value: res.data.categories[i].id,
            text: res.data.categories[i].name,
          });
        }
      });
    },

    onImageHandler(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.product.image = files[0];
    },

    createProduct() {
      let data = new FormData();
      data.append("name", this.product.name);
      data.append("description", this.product.description);
      data.append("price", this.product.price);
      data.append("category_id", this.product.category);
      if (this.product.image) {
        data.append("image", this.product.image);
      }
      axios.post('api/createProduct', data).then((res) => {
        if (res.data.status == "error") {
          this.errors = res.data.errors;
        } else {
          this.product = {
            id: "",
            name: "",
            description: "",
            price: "",
            image: "",
          };
        }
      });
    },

    searchdata: function (val) {
      axios.get("/api/search/" + val).then((res) => {
        this.products = res.data.data;
      });
    },

    loadCategories: function () {
      axios
        .get("/api/categories", {
          params: _.omit(this.selected, "categories"),
        })
        .then((response) => {
          this.categories = response.data.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    loadProducts: function () {
      axios
        .get("/api/products", {
          params: this.selected,
        })
        .then((response) => {
          this.products = response.data.data;
          this.loading = false;
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    loadPrices: function () {
      axios
        .get("/api/prices", {
          params: _.omit(this.selected, "prices"),
        })
        .then((response) => {
          this.prices = response.data;
          this.loading = false;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>
