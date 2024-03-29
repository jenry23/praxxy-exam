<template>
    <div class="container-fluid">
        <form @submit.prevent="submitForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">edit</i>
                            </div>
                            <h4 class="card-title">
                                {{ $t('global.edit') }}
                                <strong>{{ $t('cruds.product.title_singular') }}</strong>
                            </h4>
                        </div>
                        <div class="card-body">
                            <back-button></back-button>
                        </div>
                        <div class="card-body">
                            <bootstrap-alert />
                            <div class="row">
                                <div class="col-md-12">
                                    <div
                                        class="form-group bmd-form-group"
                                        :class="{
                                            'has-items': entry.name,
                                            'is-focused': activeField == 'name'
                                        }"
                                    >
                                        <label class="bmd-label-floating required">{{
                                            $t('cruds.product.fields.name')
                                        }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            :value="entry.name"
                                            @input="updateName"
                                            @focus="focusField('name')"
                                            @blur="clearFocus"
                                            required
                                        />
                                    </div>
                                    <div
                                        class="form-group bmd-form-group"
                                        :class="{
                                            'has-items': entry.description,
                                            'is-focused': activeField == 'description'
                                        }"
                                    >
                                        <label class="bmd-label-floating">{{
                                            $t('cruds.product.fields.description')
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            rows="5"
                                            :value="entry.description"
                                            @input="updateDescription"
                                            @focus="focusField('description')"
                                            @blur="clearFocus"
                                        ></textarea>
                                    </div>
                                    <div
                                        class="form-group bmd-form-group"
                                        :class="{
                                            'has-items': entry.date,
                                            'is-focused': activeField == 'date'
                                        }"
                                    >
                                        <label class="bmd-label-floating required">{{
                                            $t('cruds.product.fields.date_time')
                                        }}</label>
                                        <datetime-picker
                                            class="form-control"
                                            type="text"
                                            picker="date"
                                            :value="entry.date"
                                            @input="updateDate"
                                            @focus="focusField('date')"
                                            @blur="clearFocus"
                                            required
                                        >
                                        </datetime-picker>
                                    </div>
                                    <div
                                        class="form-group bmd-form-group"
                                        :class="{
                                            'has-items': entry.category,
                                            'is-focused': activeField == 'category'
                                        }"
                                    >
                                        <label class="bmd-label-floating">{{
                                            $t('cruds.product.fields.category')
                                        }}</label>
                                        <input
                                            class="form-control"
                                            type="text"
                                            :value="entry.category"
                                            @input="updateCategory"
                                            @focus="focusField('category')"
                                            @blur="clearFocus"
                                            required
                                        />
                                    </div>

                                    <div class="form-group">
                                        <label>{{ $t('cruds.product.fields.photo') }}</label>
                                        <attachment
                                            :route="getRoute('products')"
                                            :collection-name="'product_photo'"
                                            :media="entry.photo"
                                            :model-id="$route.params.id"
                                            :max-file-size="2"
                                            :component="'pictures'"
                                            :accept="'image/*'"
                                            @file-uploaded="insertPhotoFile"
                                            @file-removed="removePhotoFile"
                                            :max-files="1"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <vue-button-spinner
                                class="btn-primary"
                                :status="status"
                                :isLoading="loading"
                                :disabled="loading"
                            >
                                {{ $t('global.save') }}
                            </vue-button-spinner>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Attachment from '@components/Attachments/Attachment'

export default {
    components: {
        Attachment
    },
    data () {
        return {
            status: '',
            activeField: ''
        }
    },
    computed: {
        ...mapGetters('ProductsSingle', ['entry', 'loading', 'lists'])
    },
    beforeDestroy () {
        this.resetState()
    },
    watch: {
        '$route.params.id': {
            immediate: true,
            handler () {
                this.resetState()
                this.fetchEditData(this.$route.params.id)
            }
        }
    },
    methods: {
        ...mapActions('ProductsSingle', [
            'fetchEditData',
            'updateData',
            'resetState',
            'setName',
            'setDescription',
            'setPrice',
            'setDate',
            'setCategory',
            'insertPhotoFile',
            'removePhotoFile'
        ]),
        updateName (e) {
            this.setName(e.target.value)
        },
        updateDescription (e) {
            this.setDescription(e.target.value)
        },
        updatePrice (e) {
            this.setPrice(e.target.value)
        },
        updateDate (e) {
            this.setDate(e.target.value);
        },
        updateCategory (e) {
            this.setCategory(e.target.value)
        },
        updateTag (value) {
            this.setTag(value)
        },
        getRoute (name) {
            return `${axios.defaults.baseURL}${name}/media`
        },
        submitForm () {
            this.updateData()
                .then(() => {
                    this.$router.push({ name: 'products.index' })
                    this.$eventHub.$emit('update-success')
                })
                .catch(error => {
                    this.status = 'failed'
                    _.delay(() => {
                        this.status = ''
                    }, 3000)
                })
        },
        focusField (name) {
            this.activeField = name
        },
        clearFocus () {
            this.activeField = ''
        }
    }
}
</script>
