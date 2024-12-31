$(document).ready(function () {
  // Success orderan
  $(".success_order").click(function () {
    var order_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to success orderan from database?",
      icon: "success",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Update Successfully",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { order_id: order_id, action: "remove_success" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });
  // Accept orderan
  $(".ordering_order").click(function () {
    var order_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to Accept orderan from database?",
      icon: "success",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Update Successfully",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { order_id: order_id, action: "remove_ordering" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // Accept orderan
  $(".accept_order").click(function () {
    var order_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to Accept orderan from database?",
      icon: "success",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Update Successfully",
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { order_id: order_id, action: "remove_accept" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // Delete orderan all
  $(".delete_order_all").click(function () {
    Swal.fire({
      title: "Are you sure you want to remove orderan from database?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { action: "remove_order_all" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
              window.location.href = "view_orders.php";
            }, 2000);
          },
        });
      }
    });
  });

  // Delete orderan id
  $(".delete_order").click(function () {
    var order_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove orderan from database?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { order_id: order_id, action: "remove_order" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
              window.location.href = "view_orders.php";
            }, 2000);
          },
        });
      }
    });
  });

  // delete manager
  $(".delete_manager").click(function () {
    var manager_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove manager from database?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { manager_id: manager_id, action: "remove_manager" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // show the modal - update manager
  $(".update_manager").click(function () {
    id = $(this).attr("id");

    manager_image = $("#image_" + id).attr("src");
    manager_name = $("#name_" + id).text();
    manager_phone = $("#phone_" + id).text();
    manager_email = $("#email_" + id).text();
    manager_username = $("#username_" + id).text();
    manager_password = $("#password_" + id).text();

    $("#NAME").text("Update Manager - id:" + id);

    $("#hidden_id").val(id);

    $("#mi").attr("src", manager_image);
    $("#mn").val(manager_name);
    $("#mp").val(manager_phone);
    $("#me").val(manager_email);
    $("#mu").val(manager_username);
    $("#mpass").val(manager_password);

    $("#add_modal").modal("show");
  });

  //**********************************************************************************************************************

  // delete team member
  $(".delete_member").click(function () {
    var member_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove team member from database?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { member_id: member_id, action: "remove_member" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // show the modal - update team member
  $(".update_member").click(function () {
    id = $(this).attr("id");

    gambar = $("#image_" + id).attr("src");
    nama = $("#nama_" + id).text();
    alamat = $("#alamat_" + id).text();
    tanah = $("#tanah_" + id).text();
    bangunan = $("#bangunan_" + id).text();
    tidur = $("#tidur_" + id).text();
    mandi = $("#mandi_" + id).text();
    mobil = $("#mobil_" + id).text();
    att = $("#att_" + id).text();

    $("#NAME").text("Update Member - id:" + id);

    $("#hidden_id").val(id);

    $("#mi").attr("src", gambar);
    $("#mn").val(nama);
    $("#ma").val(alamat);
    $("#mt").val(tanah);
    $("#mb").val(bangunan);
    $("#mtd").val(tidur);
    $("#mm").val(mandi);
    $("#mmb").val(mobil);
    $("#mat").val(att);

    $("#add_modal").modal("show");
  });

  //**********************************************************************************************************************

  // delete admin
  $(".delete_admin").click(function () {
    var admin_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove admin from database?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { admin_id: admin_id, action: "remove_admin" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // show the modal - update admin
  $(".update_admin").click(function () {
    id = $(this).attr("id");

    admin_image = $("#image_" + id).attr("src");
    admin_name = $("#name_" + id).text();
    admin_phone = $("#phone_" + id).text();
    admin_email = $("#email_" + id).text();
    admin_username = $("#username_" + id).text();
    admin_password = $("#password_" + id).text();

    $("#NAME").text("Update Admin - id:" + id);

    $("#hidden_id").val(id);

    $("#ai").attr("src", admin_image);
    $("#an").val(admin_name);
    $("#ap").val(admin_phone);
    $("#ae").val(admin_email);
    $("#au").val(admin_username);
    $("#apass").val(admin_password);

    $("#add_modal").modal("show");
  });

  //**********************************************************************************************************************

  // delete menu
  $(".delete_menu").click(function () {
    var menu_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove menu category?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { menu_id: menu_id, action: "remove_menu" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });

        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });
      }
    });
  });

  // show the modal - update menu
  $(".update_menu").click(function () {
    id = $(this).attr("id");

    menu_image = $("#image_" + id).attr("src");
    menu_name = $("#name_" + id).text();

    $("#NAME").text("Update Menu - id:" + id);

    $("#hidden_id").val(id);

    $("#mi").attr("src", menu_image);
    $("#mn").val(menu_name);

    $("#add_modal").modal("show");
  });

  //**********************************************************************************************************************

  // delete menu item
  $(".delete_item").click(function () {
    var item_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove item from menu?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { item_id: item_id, action: "remove_item" },
          success: function (data) {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // show the modal - update item
  $(".update_item").click(function () {
    id = $(this).attr("id");

    item_image = $("#image_" + id).attr("src");
    item_name = $("#name_" + id).text();
    item_price = $("#price_" + id).text();
    item_desc = $("#desc_" + id).text();
    item_menu = $(".item_" + id).attr("id");

    $("#NAME").text("Update Menu - id:" + id);

    $("#hidden_id").val(id);

    $("#mi").attr("src", item_image);
    $("#in").val(item_name);
    $("#ip").val(item_price);
    $("#id").val(item_desc);
    $("#hidden_menu").val(item_menu);
    $("#hidden_image").val(item_image);

    $("#add_modal").modal("show");
  });

  //**********************************************************************************************************************

  // delete topping Category
  $(".delete_toppingCat").click(function () {
    var toppingCat_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove topping category?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { toppingCat_id: toppingCat_id, action: "remove_toppingCat" },
          success: function (data) {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // show the modal - update topping category
  $(".update_toppingCat").click(function () {
    id = $(this).attr("id");

    toppingCat_name = $("#name_" + id).text();

    $("#NAME").text("Update Topping Category - id:" + id);

    $("#hidden_id").val(id);

    $("#tn").val(toppingCat_name);

    $("#add_modal").modal("show");
  });

  //**********************************************************************************************************************

  // delete topping
  $(".delete_topping").click(function () {
    var topping_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove this topping?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { topping_id: topping_id, action: "remove_topping" },
          success: function (data) {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // show the modal - update item
  $(".update_topping").click(function () {
    id = $(this).attr("id");

    topping_image = $("#image_" + id).attr("src");
    topping_name = $("#name_" + id).text();
    topping_price = $("#price_" + id).text();
    topping_price = topping_price.substring(0, topping_price.length - 1);
    // topping_menu = $(".topping_"+id).attr("id");

    $("#NAME").text("Update topping - id:" + id);

    $("#hidden_id").val(id);

    $("#mi").attr("src", topping_image);
    $("#tn").val(topping_name);
    $("#tp").val(topping_price);

    //  $('#hidden_menu').val(item_menu);

    $("#add_modal").modal("show");
  });

  //**********************************************************************************************************************

  // delete finished offers
  $("#delete_finished_offers").click(function () {
    Swal.fire({
      title: "Are you sure you want to delete all finished offers?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { action: "remove_finished_offers" },
          success: function (data) {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // delete all offers
  $("#delete_all_offers").click(function () {
    Swal.fire({
      title: "Are you sure you want to delete all offers?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { action: "remove_all_offers" },
          success: function (data) {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // delete topping
  $(".delete_offer").click(function () {
    var offer_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove this offer?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { offer_id: offer_id, action: "remove_offer" },
          success: function (data) {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  // show the modal - update offer
  $(".update_offer").click(function () {
    id = $(this).attr("id");

    offer_image = $("#image_" + id).attr("src");
    offer_name = $("#name_" + id).text();
    end_date = $("#ed_" + id).text();
    offer_pourcentage = $("#pourcentage_" + id).val();
    old_price = $("#oldprice_" + id).val();

    $("#NAME").text("Update offer - id:" + id);

    $("#hidden_id").val(id);
    $("#hidden_price").val(old_price);

    $("#mi").attr("src", offer_image);
    $("#on").text(offer_name);
    $("#p").val(offer_pourcentage);
    $("#ed").val(end_date);

    $("#add_modal").modal("show");
  });

  // update delivery
  $("#delivery").click(function () {
    cost = $("#cost").text();

    $("#NAME").text("Pajak");

    $("#del").val(cost);

    $("#add_modal").modal("show");
  });

  //  update currency
  $(".update_currency").click(function () {
    id = $(this).attr("id");

    to = $("#to_" + id).text();
    price = $("#price_" + id).text();

    $("#NAME").text("Update currency - id:" + id);

    $("#hidden_id").val(id);

    $("#cp").val(price);

    $("#add_modal2").modal("show");
  });

  //  delete currency
  $(".delete_currency").click(function () {
    var cur_id = $(this).attr("id");

    Swal.fire({
      title: "Are you sure you want to remove this currency?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          position: "center",
          icon: "success",
          title: "Removed Successfully",
          showConfirmButton: false,
          timer: 2000,
        });

        $.ajax({
          url: "../requests/update_delete.php",
          method: "post",
          data: { cur_id: cur_id, action: "remove_currency" },
          success: function () {
            setTimeout(function () {
              location.reload(true);
            }, 2000);
          },
        });
      }
    });
  });

  $("#curr").click(function () {
    $("#NAME").text("Add new currency");

    $("#add_modal3").modal("show");
  });
  $("#cancel").click(function () {
    $("#add_modal").modal("hide");
  });
});
