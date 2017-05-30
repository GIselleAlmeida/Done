var target = $("div#target");
var n = function() {
  return $("div.col-xs-2").length;
};
var newInput = function() {
  var div = $("<div/>", {
    "class": "input-group"
  });
  var input = $("<input>", {
    "class": "form-control" ,"placeholder": "username"
  });
  var input1 = $("<input>", {
    "class": "form-control" ,"placeholder": "nome"
  });
  var span = $("<span/>", {
    "class": "input-group-btn"
  });
  var button = $("<button/>", {
    "class": "removeBtn btn btn-sm btn-link",
    type: "button",
    id: n()
  });
  var glyph = $("<span/>", {
    "class": "glyphicon glyphicon-remove"
  });
  var col = $("<div/>", {
    "class": "form-group col-xs-2",
    id: "newInput-" + n()
  });



  $(glyph).appendTo(button);
  $(button).appendTo(span);
  $(input).appendTo(div);
   $(input1).appendTo(div);
  $(span).appendTo(div);
  $(div).appendTo(col);
  return col;
};

$('button#add').on('click', function() {
  $(newInput()).appendTo(target);
});

$('#target').on('click', 'button', function() {
  var target = $("#target").find("#newInput-" + this.id);
  $(target).remove();
});