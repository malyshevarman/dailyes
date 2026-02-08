<template>
  <div>
    <a-button
      style="margin-bottom: 15px;"
      @click.prevent="handleAdd"
    >
      {{value.length > 0 ? 'Добавить новый адрес' : 'Добавить адрес'}}
    </a-button>
    <a-table
      :columns="columns"
      :data-source="value"
      size="small"
      :locale="{ emptyText: 'Адреса компании' }"
      :rowKey="record => record.id"
    >
      <div
        slot="action"
        slot-scope="text, record"
      >
        <a
          @click.prevent="handleEdit(record)"
        >
          <a-icon type="edit" />
        </a>
        <a
          @click.prevent="handleDelete(record)"
        >
          <a-icon type="delete" />
        </a>
      </div>
    </a-table>
    <a-modal
      title="Добавить адрес"
      :visible="addVisible"
      @ok="handleOk"
      @cancel="addVisible = false"
      class="address-modal"
    >
      <company-addresses-form :address="address" />
    </a-modal>
  </div>
</template>

<script>
    let str = window.location.pathname
    let res = str.split("/")

    const columns = [
      //   {title: 'ID', dataIndex: 'id', key: 'id'},
        {title: 'Город', dataIndex: 'city.name', key: 'city.name'},
        {title: 'Адрес', dataIndex: 'address', key: 'address'},
       //  {title: 'График работы', dataIndex: 'work', key: 'work'},
     //    {title: 'Сайт', dataIndex: 'site', key: 'site'},
        {
            key: 'operation',
            fixed: 'right',
            width: 100,
            scopedSlots: {customRender: 'action'},
        },
    ];

    export default {
        props: {
            value: {
                type: Array,
                default: () => ([])
            }
        },
        data() {
            return {
                columns,
                res: res,
                addVisible: false,
                address: {},
                dayday:null,
            }
        },
        mounted() {
        },
        methods: {
            handleAdd() {
                this.address = {
                    lat: null,
                    long: null,
                    address: null,
                    work: false,
                    mon:this.dayday,
                    tues:this.dayday,
                    wed:this.dayday,
                    thurs:this.dayday,
                    fri:this.dayday,
                    sat:this.dayday,
                    sun:this.dayday,
                    city: {
                        name: null,
                        lat: null,
                        long: null
                    },
                    phone: '',
                    phone2: ''
                }
                this.addVisible = true
            },
            handleEdit(address) {
                if (typeof address.work === 'string' || address.work instanceof String){
                  address.work = true
                } else if (address.work === null) {
                  address.work = false
                }
                this.address = address
                this.addVisible = true
                // if (this.address.mon == null) {
                //   this.address.mon   = this.dayday
                //   this.address.tues  = this.dayday
                //   this.address.wed   = this.dayday
                //   this.address.thurs = this.dayday
                //   this.address.fri   = this.dayday
                //   this.address.sat   = this.dayday
                //   this.address.sun   = this.dayday
                // }
            },
            handleDelete(address) {
              swal({
                  title: "Вы уверены?",
                  text: "Это необратимый процесс!",
                  icon: "warning",
                  buttons: ["Нет", "Да"],
                  dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  var index = this.value.indexOf(address);
                  if (index > -1) {
                      this.value.splice(index, 1);
                  }
                }
              })
            },
            handleOk() {
                if (this.address.address == null) {
                  return false
                }
                if (this.value.indexOf(this.address) == -1) {
                    this.$emit('input', [...this.value, this.address])
                }


                this.addVisible = false
                this.address = {}
            }
        }
    }
</script>

<style scoped>

</style>
