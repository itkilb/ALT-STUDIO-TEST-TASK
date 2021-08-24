<template>
    <div class="container-fluid">
        <Header></Header>
        <div class="row">
            <div class="col-4">
                <div class="d-grid gap-1 mt-1">
                <button class="btn btn-primary" @click="$bvModal.show('modal-add')" type="button">Добавить</button>
                </div>
                <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Широта</th>
                    <th scope="col">Долгота</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="mark in markers" :key="mark.message">
                    <td> <a href="#" :id="mark.id" v-on:click='searchMark' >{{ mark.name }}</a></td>
                    <td>{{ mark.coords[0] }}</td>
                    <td>{{ mark.coords[1] }}</td>
                    <td class="text-center" :id="mark.id">
                        <button :id="mark.id" v-on:click="clickDelete" class="btn btn-outline-danger">🗑</button>
                    </td>
                    <td class="text-center" :id="mark.id">
                        <button :id="mark.id" v-on:click="showModalEdit" class="btn btn-outline-primary">✏️</button>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div style="height:100vh" class="col-8">
                 <yandex-map v-if="coords" :coords="coords"
                    :zoom="zoom"
                >
                    <ymap-marker
                    v-for="n in markers"
                    :key="n.id"
                    :marker-id="n.id"
                    :coords="n.coords"
                    :hint-content="n.name"
                    />
                </yandex-map>
            </div>
                <!-- Modal add-->
            <b-modal id="modal-add" hide-footer>
                <template #modal-title>
                 Добавить локацию
                </template>
                <div class="d-block">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Название</label>
                    <input v-bind:class="{'is-invalid': AddNameError }" v-model="Addname" type="string" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div class="invalid-feedback">
                        Введите название
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Широта</label>
                    <input min="-90" max="90" v-bind:class="{'is-invalid': AddLanError }" v-model="Addlat" type='number' step='1' class="form-control" id="exampleInputPassword1">
                    <div class="invalid-feedback">
                        Широта не должна быть пустая, минимальное значение -90 максимальное 90
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Долгота</label>
                    <input type='number' :min="-180" :max="180" v-bind:class="{'is-invalid': AddLonError }" v-model="Addlon" step='1' class="form-control" id="exampleInputPassword1">
                    <div class="invalid-feedback">
                        Долгота не должна быть пустая, минимальное значение -180 максимальное 180
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <b-button class="" block @click="$bvModal.hide('modal-add')">Закрыть</b-button>
                    <button type="button" v-on:click="createLocation" class="btn btn-primary">Отправить</button>
                </div>
            </b-modal>
            <!-- Modal Edit -->
            <b-modal id="modal-edit" hide-footer>
                <template #modal-title>
                 Изменить локацию
                </template>
                <div class="d-block">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Название</label>
                    <input v-bind:class="{'is-invalid': EditNameError }" v-model="Editname" type="string" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div class="invalid-feedback">
                        Введите название
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Широта</label>
                    <input min="-90" max="90" v-bind:class="{'is-invalid': EditLanError }" v-model="Editlat" type='number' step='1' class="form-control" id="exampleInputPassword1">
                    <div class="invalid-feedback">
                        Широта не должна быть пустая, минимальное значение -90 максимальное 90
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Долгота</label>
                    <input type='number' :min="-180" :max="180" v-bind:class="{'is-invalid': EditLonError }" v-model="Editlon" step='1' class="form-control" id="exampleInputPassword1">
                    <div class="invalid-feedback">
                        Долгота не должна быть пустая, минимальное значение -180 максимальное 180
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <b-button class="" block @click="$bvModal.hide('modal-edit')">Закрыть</b-button>
                    <button type="button" v-on:click="sendEdit" class="btn btn-primary">Отправить</button>
                </div>
            </b-modal>

        </div>
    </div>
</template>

<script>
import {yandexMap, ymapMarker, loadYmap} from 'vue-yandex-maps';
import Header from './Header.vue';

const settings = {
  apiKey: '1920382c-f31a-46c4-8da0-7417f056c2f1',
  lang: 'ru_RU',
  version: '2,1',
};

export default {
  data() {
    return {
      // Errors
      AddNameError: false,
      AddLanError: false,
      AddLonError: false,
      EditNameError: false,
      EditLanError: false,
      EditLonError: false,
      // Add
      Addname: null,
      Addlon: null,
      Addlat: null,
      // Edit
      Editname: null,
      Editlon: null,
      Editlat: null,
      EditMasive: null,
      Editid: null,
      EditIndexOf: null,

      cordsUser: null,
      markers: [
        // {
        //     id: "1",
        //     name: "test",
        //     coords: [55.727790, 37.475986]
        // }
      ],
      zoom: 10,
      coords: null,
    };
  },
  methods: {
    searchMark(e) {
      this.coords = this.markers.filter(function(val) {
        return val.id === Number(e.target.id);
      })[0].coords;
    },
    validateFormAdd() {
      if (this.Addname) {
        this.AddNameError = false;
        if (this.Addlon && this.Addlon > -181 && this.Addlon < 181) {
          this.AddLonError = false;
          if (this.Addlat && this.Addlat > -91 && this.Addlat < 91) {
            this.AddLanError = false;
            return true;
          } else {
            this.AddLanError = true;
          }
        } else {
          this.AddLonError = true;
        }
      } else {
        this.AddNameError = true;
      }
    },
    validateFormEdit() {
      if (this.Editname) {
        this.EditNameError = false;
        if (this.Editlon && this.Addlon > -181 && this.Addlon < 181) {
          this.EditLonError = false;
          if (this.Editlat && this.Addlat > -91 && this.Addlat < 91) {
            this.EditLanError = false;
            return true;
          } else {
            this.EditLanError = true;
          }
        } else {
          this.EditLonError = true;
        }
      } else {
        this.EditNameError = true;
      }
    },
    showModalEdit(e) {
      this.$bvModal.show('modal-edit');

      this.EditMasive = this.markers.filter(function(val) {
        return val.id === Number(e.target.id);
      })[0];

      this.Editid = this.EditMasive.id;
      this.Editname = this.EditMasive.name;
      this.Editlat = this.EditMasive.coords[0];
      this.Editlon = this.EditMasive.coords[1];
    },
    sendEdit() {
      if (this.validateFormEdit()) {
        axios({
          headers: {
            Authorization: 'Bearer ' + localStorage.token,
          },
          method: 'put',
          url: 'api/location/' + this.Editid,
          data: {
            lon: this.Editlon,
            lat: this.Editlat,
            name: this.Editname,
          },
        }).then((response) => {
          this.$bvModal.hide('modal-edit');
          this.EditIndexOf = this.markers.map((el) => el.id).indexOf(Number(this.Editid));
          this.markers[this.EditIndexOf].name = this.Editname;
          this.markers[this.EditIndexOf].coords[0] = this.Editlat;
          this.markers[this.EditIndexOf].coords[1] = this.Editlon;
        }).catch((error) => {
          console.log(error);
        });
      }
    },
    clickDelete(e) {
      axios({
        headers: {
          Authorization: 'Bearer ' + localStorage.token,
        },
        method: 'delete',
        url: 'api/location/' + e.target.id,
      }).then((response) => {
        this.markers.splice(this.markers.map((el) => el.id).indexOf(Number(e.target.id)), 1);
      });
    },
    createLocation() {
      if (this.validateFormAdd()) {
        axios({
          method: 'post',
          url: 'api/location',
          data: {
            lon: this.Addlon,
            lat: this.Addlat,
            name: this.Addname,
          },
          headers: {
            Authorization: 'Bearer ' + localStorage.token,
          },
        }).then((response) => {
          this.markers.push({
            id: response.data.data.id,
            coords: [this.Addlat, this.Addlon],
            name: this.Addname,
          });

          this.$bvModal.hide('modal-add');
        })
            .catch((error) => {
              console.log(error);
            });
      }
    },
    getLocation() {
      axios.get('api/location', {
        headers: {
          Authorization: 'Bearer ' + localStorage.token,
        },
      })
          .then((response) => {
            for (const key in response.data.data) {
              this.markers.push({
                id: response.data.data[key].id,
                coords: [response.data.data[key].lat, response.data.data[key].lon],
                name: response.data.data[key].name,
              });
            }
          })
          .catch((error) => {
            console.log(error);
          });
    },
    editLocation() {

    },
  },
  async mounted() {
    await loadYmap({settings, debug: true});

    await this.getLocation();

    const location = ymaps.geolocation.get({
      provider: 'auto',
      autoReverseGeocode: false,
    });

    location.then((data) => {
      this.coords = data.geoObjects.get(0).geometry.getCoordinates();
    });
  },
  components: {yandexMap, ymapMarker, loadYmap, Header},
};
</script>

<style scoped>
.ymap-container {
  height: 100%;
}
</style>
