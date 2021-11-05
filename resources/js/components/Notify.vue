<template>
</template>

<script>
import toastr from "toastr";
export default {
  props: ["user"],
  mounted() {
    window.Echo.channel("delivery").listen("TicketDeliverySendEvent", (e) => {
    //   console.log(e);
      if (this.user == e.receptor) {
        toastr.success(
          `Entrego: ${e.emisor}<br/>Ticket: ${e.ticket}`,
          "Entrega de Archivos"
        );
      }
    });
    window.Echo.channel("notification").listen("MessageSendEvent", (e) => {
    //   console.log(e);
      if (this.user == e.receptor) {
        toastr.info(`${e.emisor}: ${e.message}`, "Mensaje");
      }
    });
    window.Echo.channel("status").listen("ChangeStatusSendEvent", (e) => {
    //   console.log(e);
      if (this.user == e.receptor) {
        toastr.warning(
          `Ticket: ${e.ticket}<br/> Estado: ${e.status}`,
          "Cambio de Estado"
        );
      }
    });

    window.Echo.channel("creado").listen("TicketCreateSendEvent", (e) => {
    //   console.log(e);
      if (this.user == e.receptor) {
        toastr.warning(
          `Creador: ${e.emisor}<br/>Ticket: ${e.ticket} `,
          "Creacion de Ticket"
        );
      }
    });
    window.Echo.channel("priority").listen("ChangePrioritySendEvent", (e) => {
    //   console.log(e);
      if (this.user == e.receptor) {
        toastr.error(
          `Creador: ${e.emisor}<br/>Prioridad: ${e.prioridad}<br/>Ticket: ${e.ticket} `,
          "Cambio de prioridad"
        );
      }
    });
    window.Echo.channel("change").listen("ChangeTicketSendEvent", (e) => {
    //   console.log(e);
      if (this.user == e.receptor) {
        toastr.error(
          `Modificado por: ${e.emisor}<br/>Ticket: ${e.ticket} `,
          "Cambio de Informacion"
        );
      }
    });
  },
  data: function () {
    return {
      message: "",
    };
  },
};
</script>

<style>
</style>
