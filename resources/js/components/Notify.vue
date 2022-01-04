<template>
  <div>
    <audio id="audio" controls>
      <source type="audio/wav" src="/assets/audio/notify.mp3" />
    </audio>
  </div>
</template>

<script>
import toastr from "toastr";
export default {
  props: ["user"],
  mounted() {
    const audio = document.querySelector("#audio");
    window.Echo.channel("delivery").listen("TicketDeliverySendEvent", (e) => {
      console.log(e);
      if (this.user == e.receptor) {
        toastr.success(
          `Entrego: ${e.emisor}<br/>Ticket: ${e.ticket}`,
          "Entrega de Archivos"
        );
        audio.play();
      }
    });
    window.Echo.channel("notification").listen("MessageSendEvent", (e) => {
      console.log(e);
      if (this.user == e.receptor) {
        toastr.info(`${e.emisor}: ${e.message}`, "Mensaje");
        audio.play();
      }
    });
    window.Echo.channel("status").listen("ChangeStatusSendEvent", (e) => {
      console.log(e);
      if (this.user == e.receptor) {
        toastr.warning(
          `Ticket: ${e.ticket}<br/> Estado: ${e.status}`,
          "Cambio de Estado"
        );
        audio.play();
      }
    });

    window.Echo.channel("creado").listen("TicketCreateSendEvent", (e) => {
      console.log(e);
      if (this.user == e.receptor) {
        toastr.warning(
          `Creador: ${e.emisor}<br/>Ticket: ${e.ticket} `,
          "Creacion de Ticket"
        );
        audio.play();
      }
    });
    window.Echo.channel("priority").listen("ChangePrioritySendEvent", (e) => {
      console.log(e);
      if (this.user == e.receptor) {
        toastr.error(
          `Creador: ${e.emisor}<br/>Prioridad: ${e.prioridad}<br/>Ticket: ${e.ticket} `,
          "Cambio de prioridad"
        );
        audio.play();
      }
    });
    window.Echo.channel("change").listen("ChangeTicketSendEvent", (e) => {
      console.log(e);
      if (this.user == e.receptor) {
        toastr.error(
          `Modificado por: ${e.emisor}<br/>Ticket: ${e.ticket} `,
          "Cambio de Informacion"
        );
        audio.play();
      }
    });
  },
  data: function () {
    return {
      message: "",
    };
  },
  methods: {
    notify() {
      if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
      } else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        var notification = new Notification("Hi there!");
      } else if (Notification.permission !== "denied") {
        Notification.requestPermission(function (permission) {
          // If the user accepts, let's create a notification
          if (permission === "granted") {
            var notification = new Notification("Hi there!");
          }
        });
      }
    },
  },
};
</script>

<style scoped>
#audio {
  display: none;
}
</style>
