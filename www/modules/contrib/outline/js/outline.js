/**
 * @file
 * Outline behaviors.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  // Outline Icon
  //var icon_path = drupalSettings.outline.path + '/images/outline.gif';

  var jstree = $('.tree-container').jstree({
    ui: {
      select_limit: 1
    },
    dnd: {
      check_while_dragging: true
    },
    core: {
      animation: 300,
      multiple: false,
      check_callback: function (operation, node, node_parent, node_position, more) {
        // operation can be 'create_node', 'rename_node', 'delete_node',
        // 'move_node', 'copy_node' or 'edit' in case of 'rename_node'
        // node_position is filled with the new node name
        console.log(node.id + ' ' + node_parent.id);

        // Exit if invalid move drag target.
        if (operation === 'move_node') {
          if (node.id === node_parent.id ||
              node_parent.li_attr['entry-site'] == '1') {
            return false;
          }
        }

        return true;
      }
    },
    types: {
      // drupalSettings.path.baseUrl  or Drupal.url()
      outline: {
        //icon: {image: icon_path},
        valid_children: ['entry'],
        max_children: 500,
        max_depth: 30
      },
      entry: {
        valid_children: ['entry'],
        max_children: 500,
        max_depth: 30
      }
    },
    plugins: [
      // 'checkbox',
      // 'conditionalselect',
      // 'massload',
      // 'search',
      // 'sort',
      // 'wholerow',
      'contextmenu',
      'changed',
      'dnd',
      'json_data',
      'state',
      'types',
      'unique'
    ],
    contextmenu: {
      items: function ($node) {
        var tree = $('.tree-container').jstree(true);
        return {
          // Create: {
          //   separator_before: false,
          //   separator_after: false,
          //   label: 'Create',
          //   action: function (obj) {
          //     $node = tree.jstree('create_node', $node);
          //     tree.jstree('edit', $node);
          //   }
          // },
          Edit: {
            separator_before: false,
            separator_after: false,
            label: 'Edit',
            action: function (obj) {
              var treeId = $node.id;
              var oid = $('#' + treeId).attr('outline-id');
              var url = $('#' + treeId).attr('entity-edit') + '?destination=/outline/' + oid;
              window.location.replace(url);
            }
          },
          Rename: {
            separator_before: false,
            separator_after: false,
            label: 'Rename',
            action: function (obj) {
              tree.edit($node);
            }
          },
          Remove: {
            separator_before: false,
            separator_after: false,
            label: 'Delete',
            action: function (obj) {
              tree.delete_node($node);
            }
          }
        };
      }
    }
  });

  jstree.on('select_node.jstree', function (e, data) {
    console.log(data.node.id);
  });

  jstree.on('rename_node.jstree', function (e, data) {

    // Get the renamed entry's id
    var treeId = data.node.id;
    var id = $('#' + treeId).attr('entity-id');
    var name = data.text;

    // Execute ajax.
    var url = 'outline/rename-entry/' + id + '/' + name;
    var ajax = Drupal.ajax({
      url: Drupal.url(url)
    });
    ajax.execute();
  });

  jstree.on('delete_node.jstree', function (e, data) {

    // Get the deleted entry's id
    var treeId = data.node.id;
    var id = $('#' + treeId).attr('entity-id');

    // Execute ajax.
    var url = 'outline/delete-entry/' + id;
    var ajax = Drupal.ajax({
      url: Drupal.url(url)
    });
    ajax.execute();
  });

  // Open entries on hover
  // jstree.bind("hover_node.jstree", function (e, data) {
  //   var node = data.node; // the hovered node
  //   var tree_instance = data.instance; // tree instance
  //   tree_instance.open_node(node);
  // });

  // Drag and Drop
  $(document)
  // .on('dnd_move.vakata', function (e, data) {
  // var target = $(data.event.target);
  // var theNode = $("#tree").jstree(true).get_node(data.data.nodes[0]);
  // var theNode = jstree.get_node(data.data.nodes[0]);
  // var open = jstree.open_node(theNode);
  // })
      .on('dnd_stop.vakata', function (e, data) {

        // Get tree reference.
        var jstree = $('.tree-container').jstree(true);

        // Get the dragged entry's id.
        var treeId = data.data.nodes[0];
        var id = $('#' + treeId).attr('entity-id');

        // Get the dragged entry's current parent tree id.
        var parentTreeId = jstree.get_node(treeId).parent;

        // Get the new parent (drag target) id.
        var newParentTreeId = $('#' + data.event.target.id).attr('id');
        newParentTreeId = newParentTreeId.substring(0, newParentTreeId.length - 7);
        var newParentId = $('#' + newParentTreeId).attr('entity-id');

        // Get the dragged entry's children.
        var children = jstree.get_node(treeId).children;
        var dragToChild = jQuery.inArray(newParentTreeId, children) > -1;

        // Prevent drag to self, drag to current parent, drag to any child.
        if (treeId !== newParentTreeId &&
            treeId !== parentTreeId &&
            !dragToChild) {

          // Open target entry.
          var node = jstree.get_node(newParentTreeId);
          jstree.open_node(node);
          $('.tree-container').jstree('deselect_all');

          // Execute ajax.
          var url = 'outline/parent-entry/' + id + '/' + newParentId;
          var ajax = Drupal.ajax({
            url: Drupal.url(url)
          });
          ajax.execute();
          jstree.select_node(node);
        }
      });

  // Load entry when tree node is clicked.
  jstree.on('changed.jstree', function (e, data) {

    if (data.action !== 'select_node') {
      return;
    }

    var entryContainer = $('.entry-container');
    var unloadForm = entryContainer.find('form')[0];
    Drupal.detachBehaviors(unloadForm, null, 'unload');

    // Get the <li>
    var selector = 'li#' + data.node.id;
    var li = $(selector);

    var type = li.attr('entity-type');
    var id = li.attr('entity-id');
    var mode = li.attr('entity-mode');
    var render = '';

    // Get the outline's render setting.
    var outline = $('.outline');

    if (outline.hasClass('render-display')) {
      render = '0';
    }
    else if (outline.hasClass('render-form')) {
      render = '1';
    }

    var url = 'outline/render-entry/' +
        type + '/' +
        id + '/' +
        render + '/' +
        mode;
    var ajax = Drupal.ajax({
      url: Drupal.url(url)
    });
    ajax.execute();

    // Select root node.
    // jstree.jstree('select_node', 'ul > li:first');
    // var Selectednode = jstree.jstree('get_selected');
    // jstree.jstree('open_node', Selectednode, false, true);

  });

  /**
   * Move a block in the blocks table from one region to another.
   *
   * This behavior is dependent on the tableDrag behavior, since it uses the
   * objects initialized in that behavior to update the row.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the drag behavior to a applicable table element.
   */
  Drupal.behaviors.entryDrag = {

    attach: function (context, settings) {
      if (!settings.outline) {
        return;
      }
      var backStep = settings.outline.backStep;
      var forwardStep = settings.outline.forwardStep;
      // Get the blocks tableDrag object.
      var tableDrag = Drupal.tableDrag.outline;
      if (!tableDrag) {
        return;
      }
      var $table = $('#outline');
      var rows = $table.find('tr').length;

      // When a row is swapped, keep previous and next page classes set.
      tableDrag.row.prototype.onSwap = function (swappedRow) {
        $table.find('tr.outline-entry-preview').removeClass('outline-entry-preview');
        $table.find('tr.outline-entry-divider-top').removeClass('outline-entry-divider-top');
        $table.find('tr.outline-entry-divider-bottom').removeClass('outline-entry-divider-bottom');

        var tableBody = $table[0].tBodies[0];
        if (backStep) {
          for (var n = 0; n < backStep; n++) {
            $(tableBody.rows[n]).addClass('outline-entry-preview');
          }
          $(tableBody.rows[backStep - 1]).addClass('outline-entry-divider-top');
          $(tableBody.rows[backStep]).addClass('outline-entry-divider-bottom');
        }

        if (forwardStep) {
          for (var k = rows - forwardStep - 1; k < rows - 1; k++) {
            $(tableBody.rows[k]).addClass('outline-entry-preview');
          }
          $(tableBody.rows[rows - forwardStep - 2]).addClass('outline-entry-divider-top');
          $(tableBody.rows[rows - forwardStep - 1]).addClass('outline-entry-divider-bottom');
        }
      };
    }
  };

  /**
   * Ajax command to render the currently selected entity.
   *
   * @param {Drupal.Ajax} ajax
   *   {@link Drupal.Ajax} object created by {@link Drupal.ajax}.
   * @param {object} response
   *   JSON response from the Ajax request.
   * @param {number} [status]
   *   XMLHttpRequest status.
   */
  Drupal.AjaxCommands.prototype.renderEntry = function (ajax, response, status) {
    var renderedEntry = response.renderedEntry;
    var entryContainer = $('.entry-container');
    entryContainer.html(renderedEntry);
    var form = entryContainer.find('form')[0];
    Drupal.attachBehaviors(form, Drupal.settings);
  };

  /**
   * Ajax command to set an entry's parent entry.
   *
   * @param {Drupal.Ajax} ajax
   *   {@link Drupal.Ajax} object created by {@link Drupal.ajax}.
   * @param {object} response
   *   JSON response from the Ajax request.
   * @param {number} [status]
   *   XMLHttpRequest status.
   */
  Drupal.AjaxCommands.prototype.parentEntry = function (ajax, response, status) {
    // var renderedEntry = response.renderedEntry;
    // var entryContainer = $('.entry-container');
    // entryContainer.html(renderedEntry);
    // var form = entryContainer.find('form')[0];
    // Drupal.attachBehaviors(form, Drupal.settings);
  };

  /**
   * Ajax command to set an entry's name.
   *
   * @param {Drupal.Ajax} ajax
   *   {@link Drupal.Ajax} object created by {@link Drupal.ajax}.
   * @param {object} response
   *   JSON response from the Ajax request.
   * @param {number} [status]
   *   XMLHttpRequest status.
   */
  Drupal.AjaxCommands.prototype.renameEntry = function (ajax, response, status) {
    // var renderedEntry = response.renderedEntry;
    // var entryContainer = $('.entry-container');
    // entryContainer.html(renderedEntry);
    // var form = entryContainer.find('form')[0];
    // Drupal.attachBehaviors(form, Drupal.settings);
  };

})(jQuery, Drupal, drupalSettings);


// for(var i in CKEDITOR.instances) {
//   // var editor = CKEDITOR.dom.element.get(form).getEditor();
//   var instance = CKEDITOR.instances[i];
//   instance.destroy();
// }

// if (CKEDITOR.instances[hiddenCKEditorID]) {
//   CKEDITOR.instances[hiddenCKEditorID].destroy(true);
// }
// Drupal.detachBehaviors(form, null, 'unload');
// form = entryContainer.find('form')[0];

// var settings = response.settings || ajax.settings || Drupal.settings;
// var elements = entryContainer.find(selector).once('behavior-name');
// var form = $('.entry-container form');
// var elements = $('body').find('.entry-container').once('render-entity');


/*
 'core' : {
 'animation' : 0,
 'themes' : { 'default' : true }
 },
 'types' : {
 '#' : {
 'max_children' : 1,
 'max_depth' : 4,
 'valid_children' : ['root']
 },
 'root' : {
 'icon' : '/static/3.3.3/assets/images/tree_icon.png',
 'valid_children' : ['default']
 },
 'default' : {
 'valid_children' : ['default','file']
 },
 'file' : {
 'icon' : 'glyphicon glyphicon-file',
 'valid_children' : []
 }
 */
