<template>
  <div id="contact-form" class="form-background">
    <div class="form-background-title">
      <p><strong>обратная связь</strong></p>
      <p>Мы всегда рады помочь!</p>
      <p>Оставьте свой вопрос и контактные данные, и мы ответим вам в ближайшее время.</p>
    </div>
    <div>
        <form id="form" v-if="!loading" class="form">

            <div class="form-block">
                <input :class="{'is-invalid': errors.city}" class="form-control" type="text" placeholder=" " v-model="order.city">
                <label for="email">Город*</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <input :class="{'is-invalid': errors.name}" class="form-control" type="text" placeholder=" " v-model="order.name">
                <label for="name">ФИО*</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <input :class="{'is-invalid': errors.phone}" class="form-control" type="text" placeholder=" " v-mask="'+7 (###) ###-##-##'" @click="startTexting" @keyup="startTexting" v-model="order.phone">
                <label for="email">Телефон*</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <input :class="{'is-invalid': errors.mail}" class="form-control" type="text" placeholder=" " v-model="order.mail">
                <label>E-mail*</label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <div class="select-side">
                  <a-icon type="down" class="glyphicon glyphicon-menu-down blue" />
                </div>
                <div class="select">
                  <select placeholder="Причина обращения" :class="{'is-invalid': errors.subject}" class="form-control">
                    <option v-for="(subject, index) in subjects"  :key="index" :value="subject">{{subject}}</option>
                  </select>
                  <small class="form-text text-muted"></small>
                </div>
            </div>

            <div class="form-block">
                <textarea class="form-control" :class="{'is-invalid': errors.description}" placeholder="Опишите Ваш вопрос" v-model="order.description"></textarea>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block">
                <input ref="fileupload" id="file" class="form-control file-input" :class="{'is-invalid': errors.attachment}" type="file" @change="uploadChange($event)">
                <label for="file">
                  <a-icon type="upload"/>{{file_name != '' ? `${file_name.substr(0, 30)}...` : 'Прикрепите документ'}}
                  <span v-if="order.attachment!==''" @click="resetChange" style="font-size:18px;line-height:.5;font-weight:bold;">
                  &times;
                </span>
                </label>
                <small class="form-text text-muted"></small>
            </div>

            <div class="form-block d-flex">
                <input v-if="order.agreement" type="submit"  class="submit-button" @click.prevent="send" value="Отправить"/>
                <input v-else disabled class="submit-button disabled" type="submit" value="Отправить"/>
                <!-- <div
                  v-if="success"
                  class="subscribe-block__notify"
                  id="success-subscribe"
                  style="width: 320px;z-index: 1;top:100%;right:18%;"
                >Заявка отправлена</div> -->
            </div>

            <div class="form-block">
              <div class="checkbox">
                <input class="form-control" :class="{'is-invalid': errors.agreement}" type="checkbox" v-model="order.agreement">
                <span class="checkmark" @click="signAgreement"></span>
                <label>Отправляя форму, вы даете свое согласие на обработку<a href="/rules"> персональных данных</a></label>
                <small class="form-text text-muted"></small>
              </div>
            </div>
        </form>
    </div>
  </div>
</template>

<script>
var subject;
export default {
  data () {
    return {
      headers: {
        authorization: 'authorization-text',
      },
      order: {
        phone: '',
        name: '',
        city: '',
        mail: '',
        subject: '',
        description: '',
        agreement: false,
        attachment: ''
      },
      subjects: [
        // 'Проблема с оплатой',
        // 'Запрос информации',
        'Сообщить об ошибке',
        'Предложение по сотрудничеству',
        'Другой вопрос',
      ],
      errors: {},
      loading: false,
      submiting: false,
      success: false,
      file_name: ''
    }
  },
  mounted () {
    $('select').each(function(){
      // Variables
      var $this = $(this),
        selectOption = $this.find('option'),
        selectOptionLength = selectOption.length,
        selectedOption = selectOption.filter(':selected'),
        dur = 500;

      $this.hide();
      // Wrap all in select box
      // $this.wrap('<div class="select"></div>');
      // Style box
      $('<div>',{
        class: 'select__gap',
        text: 'Причина обращения*'
      }).insertAfter($this);

      var selectGap = $this.next('.select__gap'),
        caret = selectGap.find('.caret');
      // Add ul list
      $('<ul>',{
        class: 'select__list'
      }).insertAfter(selectGap);

      var selectList = selectGap.next('.select__list');
      // Add li - option items
      for(var i = 0; i < selectOptionLength; i++){
        $('<li>',{
          class: 'select__item',
          html: $('<span>',{
            text: selectOption.eq(i).text()
          })
        })
        .attr('data-value', selectOption.eq(i).val())
        .appendTo(selectList);
      }
      // Find all items
      var selectItem = selectList.find('li');

      selectList.slideUp();
      selectGap.on('click', function(){
        if(!$(this).hasClass('on')){
          $(this).addClass('on');
          selectList.slideDown();

          selectItem.on('click', function(){
            var chooseItem = $(this).data('value');

            $('select').val(chooseItem).attr('selected', 'selected');
            selectGap.text($(this).find('span').text());
            subject = chooseItem;
            selectList.slideUp();
            selectGap.removeClass('on');
          });

        } else {
          $(this).removeClass('on');
          selectList.slideUp();
        }
      });

    });
  },
  methods: {
    selectChange(value) {
      this.order.subject = value
    },
    uploadChange(event) {
      console.log(event.target.files[0])
      this.order.attachment = event.target.files[0]
      this.file_name = event.target.files[0].name
      // if (event.file.status !== 'uploading') {
      //   console.log(event.file, event.fileList)
      // }
      // if (event.file.status === 'done') {
      //   this.$message.success(`${event.file.name} file uploaded successfully`)
      // } else if (event.file.status === 'error') {
      //   this.$message.error(`${event.file.name} file upload failed.`)
      // }
    },
    resetChange() {
      this.order.attachment =''
      this.file_name=''
      this.$refs.fileupload.value=null
    },
    beforeUpload(file) {
      this.order.attachment = file
      console.log(file)
    },
    signAgreement() {
      this.order.agreement = !this.order.agreement
    },
    startTexting() {
        if (this.order.phone.length<4) {
            this.order.phone = "+7 ("
        }

    },
    send () {
      if (!this.submiting) {
        this.submiting = true
        this.success = false
        this.order.subject = subject
        const data = new FormData()
        data.set('name', this.order.name)
        data.set('phone', this.order.phone)
        data.set('city', this.order.city)
        data.set('mail', this.order.mail)
        this.order.subject == undefined ? '' : data.set('subject', this.order.subject)
        data.set('agreement', this.order.agreement)
        data.set('description', this.order.description)
        data.append('attachment', this.order.attachment)
        axios.post(`/api/frontend/callback/contact-callbackorder`, data, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(response => {
          this.submiting = false
          this.success = true
          this.errors = {}
            this.order.name=''
            this.order.phone=''
            this.order.city=''
            this.order.mail=''
            this.order.description=''
            this.order.attachment=''
            this.$bus.$emit('showModal', {
                              // title: 'Спасибо, что оставили свой отзыв',
                              text: 'Заявка отправлена'
                            })
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    }
  }
}
</script>
