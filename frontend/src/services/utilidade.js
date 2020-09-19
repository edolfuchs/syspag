import Vue from 'vue'
import moment from "moment";

let VueUtilidade = {

  install(Vue) {
    Vue.prototype.$utilidade = this;
    Vue.utilidade = this;
  },

  randomMumber(min, max) {
    min = (!min ? 1 : min)
    max = (!max ? 10 : max)
    return Math.random() * (max - min) + min;
  },

  randomString() {
    let math = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    return (math + (new Date()).getTime())
  },

  onlyNumber(value) {
    if (!value) return "";

    return value.replace(/[\. ,:-]+/g, "-").replace(/[^0-9\.]+/g, "");
  },

  onlyText(value) {
    if (!value) return "";

    value = this.toString(value);
    return value.replace(/(<([^>]+)>)/gi, "");
  },

  isEmail(value) {
    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

    return value && pattern.test(value)
  },

  isNumeric(value) {
    const pattern = /[0-9]/

    return value && pattern.test(value)
  },

  toDate(date, disableHours, format) {
    if (!date) {
      date = new Date();
    }

    if (!format) {
      format = "YYYY-MM-DD HH:mm:ss";

      if (disableHours) {
        format = "YYYY-MM-DD";
      }
    }

    return moment(date).format(format);
  },

  moneyToFloat(value) {
    if (!value || value == "") {
      return 0;
    }
    
    return parseFloat(value.toString().replace(".", "").replace(",", "."));
  },

  floatToMoney(value) {
    if (!value) {
      return "0,00";
    }

    var formatter = new Intl.NumberFormat("pt-BR", {
      style: "currency",
      currency: "BRL"
    });

    value = formatter
      .format(value)
      .replace("R$", "")
      .trim();

    return value;
  },

};

Vue.use(VueUtilidade)

export default VueUtilidade
