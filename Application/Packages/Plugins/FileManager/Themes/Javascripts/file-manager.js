var ImageEditor,
    encodeURL,
    show_animation,
    hide_animation,
    apply,
    apply_none,
    apply_img,
    apply_any,
    apply_video,
    apply_link,
    apply_file_rename,
    apply_file_duplicate,
    apply_folder_rename;

( function ( $, Modernizr ) {
    "use strict";

    var version             = '1.0.0';
    var active_contextmenu  = true;
    var copy_count          = 0;

    var delay = ( function ( ) {
        var timer = 0;
        return function ( callback, ms ) {
            clearTimeout( timer );
            timer = setTimeout( callback, ms );
        };
    })( );

    var FileManager = {

        contextActions: {

            copy_url : function ( $trigger ) {
                var url = $trigger.attr( 'data-file-url' );

                bootbox.alert(
                    'URL:<br/>' +
                    '<div class="input-append" style="width:100%">' +
                    '<input id="url_text' + copy_count + '" type="text" style="width:80%; height:30px;" value="' + encodeURL( url ) + '" />' +
                    '<button id="copy-button' + copy_count + '" class="btn btn-inverse copy-button" style="width:20%; height:30px;" data-clipboard-target="url_text' + copy_count + '" data-clipboard-text="Copy Me!" title="copy">' +
                    '</button>' +
                    '</div>'
                );

                $( '#copy-button' + copy_count ).html( '<i class="icon icon-white icon-share"></i> ' + config.languages.copy );

                var client = new ZeroClipboard( $( '#copy-button' + copy_count ) );

                client.on( 'ready', function ( readyEvent ) {
                    client.on( "wrongFlash noFlash", function ( ) {
                        ZeroClipboard.destroy( );
                    });

                    client.on( 'aftercopy', function ( event ) {
                        $( '#copy-button' + copy_count ).html( '<i class="icon icon-ok"></i> ' + config.languages.ok );
                        $( '#copy-button' + copy_count ).attr( 'class', 'btn disabled' );
                        copy_count++;
                    });

                    client.on( 'error', function ( event ) { } );
                });
            },

            unzip: function ( $trigger ) {
                var url         = config.urls.extract,
                    source_path = config.current_directory + $trigger.find( 'a.link' ).attr( 'data-file' );

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        source_path: source_path
                    }
                }).done( function ( msg ) {
                    if ( msg != '' ) {
                        bootbox.alert( msg );
                    } else {
                        window.location.href = $( '#refresh' ).attr( 'href' );
                    }
                });
            },

            edit_img: function ( $trigger ) {
                var name              = $trigger.attr( 'data-file' );
                var source_url        = $trigger.attr( 'data-file-url' );
                var source_path       = $trigger.attr( 'data-source-path' );
                var source_cache_path = $trigger.attr( 'data-source-cache-path' );
                var image_editor      = $( '#image_editor' );

                image_editor.attr( 'data-file', name );
                image_editor.attr( 'data-file-url', source_url );
                image_editor.attr( 'data-source-path', source_path );
                image_editor.attr( 'data-source-cache-path', source_cache_path );
                image_editor.attr( 'src', source_url ).load( launchEditor( image_editor.attr( 'id' ), source_url ) );
            },

            duplicate: function ( $trigger ) {
                var old_name = $trigger.closest( 'figure' ).attr( 'data-file' ).trim( );

                bootbox.prompt( config.languages.duplicate, config.languages.cancel, config.languages.ok, function ( name ) {
                    if ( name !== null ) {
                        name = fix_filename(name);

                        if ( name != old_name ) {
                            execute_action( config.urls.duplicate_file, $trigger.attr( 'data-source-path' ), $trigger.attr( 'data-source-cache-path' ), name, $trigger, 'apply_file_duplicate' );
                        }
                    }
                }, old_name );
            },

            select: function ( $trigger ) {
                var url             = $trigger.attr( 'data-file-url' );
                var external        = config.field_id;
                var window_parent;

                if ( config.popup ) {
                    window_parent = window.opener;
                } else {
                    window_parent = window.parent;
                }

                if ( external != '' ) {
                    if ( config.crossdomain ) {
                        window_parent.postMessage({
                            sender: 'filemanager',
                            url: url,
                            field_id: external
                        }, '*' );
                    } else {
                        var target = $( '#' + external, window_parent.document );
                        target.val( url ).trigger( 'change' );

                        if ( typeof window_parent.filemanager_callback == 'function' ) {
                            window_parent.filemanager_callback( external );
                        }

                        close_window( );
                    }
                } else {
                    apply_any( url );
                }
            },

            copy: function ( $trigger ) {
                copy_cut_clicked( $trigger, 'copy' );
            },

            cut: function ( $trigger ) {
                copy_cut_clicked( $trigger, 'cut' );
            },

            paste: function ( ) {
                paste_to_this_dir( );
            },

            chmod: function ( $trigger ) {
                chmod( $trigger );
            },

            edit_text_file: function( $trigger ) {
                edit_text_file( $trigger );
            }
        },

        makeContextMenu: function ( ) {
            var fm = this;

            $.contextMenu({
                selector: 'figure:not(.back-directory), .list-view2 figure:not(.back-directory)',
                autoHide: true,
                build: function ( $trigger ) {
                    $trigger.addClass( 'selected' );

                    var options = {
                        callback: function ( key, options ) {
                            fm.contextActions[key]($trigger);
                        },
                        items: {}
                    };

                    // tooltip options
                    // edit image/show url
                    if ( ( $trigger.find( '.img-precontainer-mini .filetype' ).hasClass( 'png' )
                        || $trigger.find( '.img-precontainer-mini .filetype' ).hasClass( 'jpg' )
                        || $trigger.find( '.img-precontainer-mini .filetype' ).hasClass( 'jpeg' )
                        ) && ImageEditor ) {
                        options.items.edit_img = {
                            name: config.languages.edit_image,
                            icon: 'edit_img',
                            disabled: false
                        };
                    }

                    // select folder
                    if ( $trigger.hasClass( 'directory' ) && config.type != 4 ) {
                        options.items.select = {
                            name: config.languages.select,
                            icon: "",
                            disabled: false
                        };
                    }

                    options.items.copy_url = {
                        name: config.languages.show_url,
                        icon: "url",
                        disabled: false
                    };

                    // extract
                    if ( $trigger.find( '.img-precontainer-mini .filetype' ).hasClass( 'zip' ) ||
                         $trigger.find( '.img-precontainer-mini .filetype' ).hasClass( 'tar' ) ||
                         $trigger.find( '.img-precontainer-mini .filetype' ).hasClass( 'gz' ) ) {
                        options.items.unzip = {
                            name: config.languages.extract,
                            icon: "extract",
                            disabled: false
                        };
                    }

                    // edit file's content
                    if ( $trigger.find( '.img-precontainer-mini .filetype' ).hasClass( 'edit-text-file-allowed' ) ) {
                        options.items.edit_text_file = {
                            name: config.languages.edit_file,
                            icon: "edit",
                            disabled: false
                        };
                    }

                    // copy & cut
                    if ( !$trigger.hasClass( 'directory' ) && config.copy_cut_files_allowed ) {
                        options.items.copy = {
                            name: config.languages.copy,
                            icon: "copy",
                            disabled: false
                        };

                        options.items.cut = {
                            name: config.languages.cut,
                            icon: "cut",
                            disabled: false
                        };
                    } else if ( $trigger.hasClass( 'directory' ) && config.copy_cut_folders_allowed ) {
                        options.items.copy = {
                            name: config.languages.copy,
                            icon: "copy",
                            disabled: false
                        };

                        options.items.cut = {
                            name: config.languages.cut,
                            icon: "cut",
                            disabled: false
                        };
                    }

                    // paste
                    // Its not added to folders because it might confuse someone
                    if ( config.clipboard != 0 && !$trigger.hasClass( 'directory' ) ) {
                        options.items.paste = {
                            name: config.languages.paste_here,
                            icon: 'clipboard-apply',
                            disabled: false
                        };
                    }

                    // duplicate
                    if ( !$trigger.hasClass( 'directory' ) && config.duplicate ) {
                        options.items.duplicate = {
                            name: config.languages.duplicate,
                            icon: "duplicate",
                            disabled: false
                        };
                    }

                    // file permission
                    if ( !$trigger.hasClass( 'directory' ) && config.chmod_files_allowed ) {
                        options.items.chmod = {
                            name: config.languages.file_permission,
                            icon: 'key',
                            disabled: false
                        };
                    } else if ( $trigger.hasClass( 'directory' ) && config.chmod_folders_allowed ) {
                        options.items.chmod = {
                            name: config.languages.file_permission,
                            icon: 'key',
                            disabled: false
                        };
                    }

                    // fileinfo
                    options.items.sep   = '----';
                    options.items.info  = {
                        name: '<strong>' + config.languages.file_info + '</strong>',
                        disabled: true
                    };

                    options.items.name = {
                        name: $trigger.attr( 'data-file' ),
                        icon: 'label',
                        disabled: true
                    };

                    if ( $trigger.attr( 'data-type' ) == 'img' ) {
                        options.items.dimension = {
                            name: $trigger.find( '.img-dimension' ).html( ),
                            icon: 'dimension',
                            disabled: true
                        };
                    }

                    options.items.size = {
                        name: $trigger.find( '.file-size' ).html( ),
                        icon: 'size',
                        disabled: true
                    };

                    options.items.date = {
                        name: $trigger.find( '.file-date' ).html( ),
                        icon: 'date',
                        disabled: true
                    };

                    return options;
                },

                events: {
                    hide: function ( ) {
                        $( 'figure' ).removeClass( 'selected' );
                    }
                }
            });

            $( document ).on( 'contextmenu', function ( e ) {
                if ( !$( e.target ).is( 'figure' ) ) {
                    return false;
                }
            });
        },

        bindGridEvents: function( ) {
            var grid = $( 'ul.grid' );

            grid.on( 'click', '.modalAV', function ( e ) {
                e.preventDefault( );

                var _this                   = $( this );
                var preview_element         = $( '#preview-media' );
                var preview_element_to_body = $( '.preview-body' );

                preview_element.removeData( 'modal' );
                preview_element.modal({
                    backdrop: 'static',
                    keyboard: false
                });

                if ( _this.hasClass( 'audio' ) ) {
                    preview_element_to_body.css( 'height', '80px' );
                } else {
                    preview_element_to_body.css( 'height', '345px' );
                }

                $.ajax({
                    url: _this.attr( 'data-file-url' ),
                    success: function ( data ) {
                        preview_element_to_body.html( data );
                    }
                });
            });

            grid.on( 'click', '.file-preview-btn', function ( e ) {
                e.preventDefault( );

                var _this = $( this );

                $.ajax({
                    url: _this.attr( 'data-file-url' ),
                    success: function ( data ) {
                        bootbox.alert( data );
                    }
                });
            });

            grid.on( 'click', '.preview-btn', function ( ) {
                var _this   = $(this);
                var figure  = _this.closest( 'figure' );

                if ( _this.hasClass( 'disabled' ) == false ) {
                    $( '#full-img' ).attr( 'src', decodeURIComponent( figure.attr( 'data-file-url' ) ) );
                }

                return true;
            });

            grid.on( 'click', '.rename-file-btn', function ( ) {
                var _this       = $( this );
                var figure      = _this.closest( 'figure' );
                var file        = figure.attr( 'data-file' );
                var old_name    = $.trim( file );

                bootbox.prompt( config.languages.rename, config.languages.cancel, config.languages.ok, function ( name ) {
                    if ( name !== null ) {
                        name = fix_filename( name );

                        if ( name != old_name ) {
                            execute_action( config.urls.rename_file, figure.attr( 'data-source-path' ), figure.attr( 'data-source-cache-path' ), name, figure, 'apply_file_rename' );
                        }
                    }
                }, old_name );
            });

            grid.on( 'click', '.rename-folder-btn', function ( ) {
                var _this       = $( this );
                var figure      = _this.closest( 'figure' );
                var file        = figure.attr( 'data-file' );
                var old_name    = $.trim( file );

                bootbox.prompt( $('#lang_rename' ).val( ), config.languages.cancel, config.languages.ok, function ( name ) {
                    if ( name !== null ) {
                        name = fix_filename( name  ).replace( '.', '' );

                        if ( name != old_name ) {
                            execute_action( config.urls.rename_folder, figure.attr( 'data-source-path' ), figure.attr( 'data-source-cache-path' ), name, figure, 'apply_folder_rename' );
                        }
                    }
                }, old_name );
            });

            grid.on( 'click', '.delete-file-btn', function ( ) {
                var _this = $( this );
                var figure  = _this.closest( 'figure' );

                bootbox.confirm( _this.attr( 'data-confirm' ), config.languages.cancel, config.languages.ok, function ( result ) {
                    if ( result == true ) {
                        execute_action( config.urls.delete_file, figure.attr( 'data-source-path' ), figure.attr( 'data-source-cache-path' ) );
                        _this.closest( 'li' ).remove( );
                    }
                });
            });

            grid.on( 'click', '.delete-folder-btn', function ( ) {
                var _this = $( this );
                var figure  = _this.closest( 'figure' );

                bootbox.confirm( _this.attr( 'data-confirm' ), config.languages.cancel, config.languages.ok, function ( result ) {
                    if ( result == true ) {
                        execute_action( config.urls.delete_folder, figure.attr( 'data-source-path' ), figure.attr( 'data-source-cache-path' ) );
                        _this.closest( 'li' ).remove( );
                    }
                });
            });

            function handleFileLink ( $el ) {
                var figure = $el.closest( 'figure' );
                window[ $el.attr( 'data-function' ) ]( figure.attr( 'data-file' ), figure.attr( 'data-file-url' ), config.field_id );
            }

            $( 'ul.grid' ).on( 'click', '.link', function ( ) {
                handleFileLink( $( this ) );
            });

            $( 'ul.grid' ).on( 'click', 'div.box', function ( e ) {
                var link = $( this ).find( '.link' );

                if ( link.length !== 0 ) {
                    handleFileLink( link );
                } else {
                    var link = $( this ).find( '.folder-link' );

                    if ( link.length !== 0 ) {
                        document.location = $( link ).prop( 'href' );
                    }
                }
            });
            // End of link handler
        },

        makeFilters: function ( js_script ) {
            $( '#filter-input' ).on( 'keyup', function ( ) {
                $( '.filters label' ).removeClass( 'btn-inverse' );
                $( '.filters label' ).find( 'i' ).removeClass( 'icon-white' );
                $( '#ff-item-type-all' ).addClass( "btn-inverse");
                $( '#ff-item-type-all' ).find( 'i' ).addClass( 'icon-white' );

                var val = fix_filename( $( this ).val( ) ).toLowerCase( ),
                    url = config.urls.filter;

                $( this ).val( val );

                if ( js_script ) {
                    delay( function ( ) {
                        $( 'li', 'ul.grid ' ).each( function ( ) {
                            var _this   = $( this ),
                                figure  = _this.find( 'figure' );

                            if ( val != '' && figure.attr( 'data-file' ).toLowerCase( ).indexOf( val ) == -1 ) {
                                _this.hide( 100 );
                            } else {
                                _this.show( 100 );
                            }
                        });

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                filter: val
                            }
                        }).done( function ( msg ) {
                            if ( msg != '' ) {
                                bootbox.alert( msg );
                            }
                        });

                        delay( function ( ) {
                            sortUnorderedList( config.sort_order, '.' + config.sort_by );

                            lazyLoad( );
                        }, 500 );

                    }, 300 );
                }
            }).keypress( function ( e ) {
                if ( e.which == 13 ) {
                    $( '#filter' ).trigger( 'click' );
                }
            });

            // filtering
            $( '#filter' ).on( 'click', function ( ) {
                var val = fix_filename( $( '#filter-input' ).val( ) );
                window.location.href = config.urls.current + "&filter=" + val;
            });
        },

        makeUploader: function ( ) {
            $( '#uploader-btn' ).on( 'click', function ( ) {
                var path = $( '#sub_folder' ).val( ) + $( '#fldr_value').val( ) + '/';
                path = path.substring( 0, path.length - 1 );

                $( '#iframe-container' ).html( $('<iframe />', {
                    name: 'JUpload',
                    id: 'uploader_frame',
                    src: "uploader/index.php?path=" + path,
                    frameborder: 0,
                    width: "100%",
                    height: 360
                }));
            });

            $( '.upload-btn' ).on( 'click', function ( ) {
                $( '.uploader' ).show( 500 );
            });

            $( '.close-uploader' ).on( 'click', function ( ) {
                $( '.uploader' ).hide( 500 );

                setTimeout( function ( ) {
                    window.location.href = $( '#refresh' ).attr( 'href' );
                }, 420 );
            });
        },

        makeSort: function ( js_script ) {
            $( 'input[name=radio-sort]' ).on( 'click', function ( ) {
                var li              = $( this ).attr( 'data-item' );
                var li_element       = $( '#' + li );
                var label_element    = $( '.filters label' );

                label_element.removeClass( 'btn-inverse' );
                label_element.find( 'i' ).removeClass( 'icon-white' );

                $( '#filter-input' ).val( '' );

                li_element.addClass( 'btn-inverse' );
                li_element.find( 'i' ).addClass( 'icon-white' );

                if ( li == 'ff-item-type-all' ) {
                    if ( js_script ) {
                        $( '.grid li' ).show( 300 );
                    } else {
                        window.location.href = config.urls.current + '&sort_by=' + config.sort_by + '&sort_order=' + ( sort_order ? 1 : 0 );
                    }
                } else {
                    if ( $( this ).is( ':checked' ) ) {
                        $( '.grid li' ).not( '.' + li ).hide( 300 );
                        $( '.grid li.' + li ).show( 300 );
                    }
                }

                lazyLoad( );
            });

            var sort_order = config.sort_order;

            $( '.sorter' ).on( 'click', function ( ) {
                var _this = $( this ), url = $( '#url_sort' ).val( );

                if ( config.sort_by === _this.attr( 'data-sort' ) ) {
                    sort_order = sort_order == 0 ? true : false;
                } else {
                    sort_order = true;
                }

                if ( js_script ) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            sort_by: _this.attr( 'data-sort' ),
                            sort_order: ( sort_order ? 1 : 0 )
                        }
                    });

                    sortUnorderedList( sort_order, '.' + _this.attr('data-sort' ) );

                    $( 'a.sorter' ).removeClass( 'descending' ).removeClass( 'ascending' );

                    if ( sort_order ) {
                        $( '.sort-' + _this.attr( 'data-sort' ) ).addClass( 'descending' );
                    } else {
                        $( '.sort-' + _this.attr( 'data-sort' ) ).addClass( 'ascending' );
                    }

                    config.sort_by      = _this.attr( 'data-sort' );
                    config.sort_order   = sort_order ? 1 : 0;

                    lazyLoad( );
                } else {
                    window.location.href = config.urls.current + "&sort_by=" + _this.attr( 'data-sort' ) + '&sort_order=' + ( sort_order ? 1 : 0 );
                }
            });
        }
    }

    $( document ).ready( function ( ) {

        Dropzone.options.rfmDropzone = {
            dictInvalidFileType: config.languages.error_extension,
            dictFileTooBig: config.languages.error_upload,
            dictResponseError: 'SERVER ERROR',
            paramName: 'file', // The name that will be used to transfer the file
            maxFilesize: config.max_size_upload, // MB
            url: config.urls.upload,
            init: function ( ) {
                var apply = $( '#apply' ).val( );
                if ( apply != 'apply_none' ) {
                    this.on( 'success', function( file, res ) {
                        file.previewElement.addEventListener( 'click', function ( ) {
                            window['apply']( res, config.field_id );
                        });
                    });
                }
            },
            accept: function ( file, done ) {
                var extension = file.name.split( '.' ).pop( );
                extension = extension.toLowerCase( );
                if ( $.inArray( extension, config.extensions.all ) > -1 ) {
                    done( );
                } else {
                    done( config.languages.error_extension );
                }
            }
        };

        if ( config.aviary.enable ) {
            ImageEditor = new Aviary.Feather({
                apiKey: config.aviary.api.key,
                apiVersion: config.aviary.api.version,
                language: config.aviary.language,
                theme: config.aviary.theme,
                tools: config.aviary.tools,
                onSave: function ( image_id, image_url ) {
                    show_animation( );

                    var date                    = new Date( ),
                        _this                   = $( this ),
                        url                     = config.urls.save_image,
                        image                   = document.getElementById( image_id );
                        image.src               = image_url;
                        image_editor            = $( '#image_editor' ),
                        image_name              = image_editor.data( 'name' );
                        image_source_path       = image_editor.data( 'source-path' );
                        image_source_cache_path = image_editor.data( 'source-cache-path' );

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            url: image_url,
                            name: image_name,
                            source_path: image_source_path,
                            source_cache_path: image_source_cache_path,
                        }
                    }).done( function ( msg ) {
                        ImageEditor.close( );

                        $( "figure[data-name='" + image_name + "']" ).find( 'img' ).each( function ( ) {
                            _this.attr( 'src', _this.attr( 'src' ) + "?" + date.getTime( ) );
                        });

                        $( "figure[data-name='" + image_name + "']" ).find( 'figcaption a.preview-btn' ).each( function ( ) {
                            _this.attr( 'data-file-url' , _this.data( 'url' ) + "?" + date.getTime( ) );
                        });

                        hide_animation();
                    });

                    return false;
                },
                onError: function ( errorObj ) {
                    bootbox.alert( errorObj.message );
                    hide_animation( );
                }
            });
        }

        $( '#rfmDropzone' ).on( 'click','.dz-success .dz-detail', function ( ) {
            var _this = $( this );
            alert( _this.find( '.dz-filename span').tex( ) );
        });

        // Right click menu
        if ( active_contextmenu ) {
            FileManager.makeContextMenu( );
        }

        // preview image
        $( '#full-img' ).on( 'click', function ( ) {
            $('#previewLightbox').lightbox( 'hide' );
        });

        $( 'body' ).on( 'click', function ( ) {
            $( '.tip-right' ).tooltip( 'hide' );
        });

        FileManager.bindGridEvents( );

        if ( parseInt( config.files_cnt ) > parseInt( config.file_number_limit_js ) ) {
            var js_script = false;
        } else {
            var js_script = true;
        }

        FileManager.makeSort( js_script );
        FileManager.makeFilters( js_script );

        // info btn
        $( '#info' ).on( 'click', function ( ) {
            bootbox.alert('<div class="text-center"><p><strong>File Manager v.' + version + '</strong><br/></p><br/><p>Copyright © Benjamin Taluyo. All Rights Reserved.</p><br/></div>');
        });

        FileManager.makeUploader( );

        $( 'body' ).on( 'keypress', function ( e ) {
            var c = String.fromCharCode( e.which );
            if ( c == "'" || c == '"' || c == "\\" || c == '/' ) {
                return false;
            }
        });

        $( 'ul.grid li figcaption' ).on( 'click','a[data-toggle="lightbox"]', function ( ) {
            preview_loading_animation( decodeURIComponent( $(this).attr( 'data-file-url' ) ) );
        })

        $( '.create-file-btn' ).on( 'click', function ( ) {
            create_text_file( );
        });

        $( '.create-folder-btn' ).on( 'click', function ( ) {
            bootbox.prompt(
                $( '#langinsert_folder_name' ).val( ),
                config.languages.cancel,
                config.languages.ok,
                function ( name ) {
                    if ( name !== null ) {
                        name = fix_filename( name ).replace( '.', '' );

                        var url                 = config.urls.create_folder;
                        var source_path         = config.current_directory + config.current_folder + name;
                        var source_cache_path   = config.current_cache_directory + name;

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                name: name,
                                source_path: source_path,
                                source_cache_path: source_cache_path
                            }
                        }).done( function ( msg ) {
                            if ( msg != '' ) {
                                bootbox.alert( msg, function ( /*result*/ ) {
                                    setTimeout( function ( ) {
                                        window.location.href = $( '#refresh' ).attr( 'href' );
                                    }, 500 );
                                });
                            }
                        });
                    }
                },
                config.languages.new_folder
            );
        });

        $( '.view-controller button' ).on( 'click', function ( ) {
            var _this = $( this ), url = config.urls.view;

            $( '.view-controller button' ).removeClass( 'btn-inverse' );
            $( '.view-controller i' ).removeClass( 'icon-white' );

            _this.addClass( 'btn-inverse' );
            _this.find('i').addClass( 'icon-white' );

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    view: _this.attr( 'data-value' )
                }
            }).done( function ( msg ) {
                if ( msg != "" ) {
                  bootbox.alert( msg );
                }
            });

            if ( typeof $( 'ul.grid' )[ 0 ] !== 'undefined' && $( 'ul.grid' )[ 0 ] ) {
                $( 'ul.grid' )[ 0 ].className = $( 'ul.grid' )[ 0 ].className.replace( /\blist-view.*?\b/g, '' );
            }

            if (typeof $( '.sorter-container' )[ 0 ] !== 'undefined' && $( '.sorter-container' )[ 0 ] ) {
                $('.sorter-container')[ 0 ].className = $('.sorter-container')[ 0 ].className.replace(/\blist-view.*?\b/g, '');
            }

            var value = _this.attr('data-value');
            config.view = value;

            $( 'ul.grid' ).addClass( 'list-view' + value );
            $( '.sorter-container' ).addClass( 'list-view' + value );

            if ( _this.attr( 'data-value' ) >= 1 ) {
                fix_colums( 14 );
            } else {
                $( 'ul.grid li' ).css( 'width', 126 );
                $( 'ul.grid figure' ).css( 'width', 122 );
            }

            lazyLoad( );
        });

        if ( !Modernizr.touch ) {
            $( '.tip' ).tooltip({ placement: 'bottom' });
            $( '.tip-top' ).tooltip({ placement: 'top' });
            $( '.tip-left' ).tooltip({ placement: 'left' });
            $( '.tip-right' ).tooltip({ placement: 'right' });
            $( 'body' ).addClass( 'no-touch' );
        } else {
            $( '#help' ).show( );
            //Enable swiping...
            $( ".box:not(.no-effect)" ).swipe({
                //Generic swipe handler for all directions
                swipeLeft: swipe_reaction,
                swipeRight: swipe_reaction,
                //Default is 75px, set to 0 for demo so any distance triggers swipe
                threshold: 30
            });
        }

        $( '.clipboard-paste-btn' ).on( 'click', function ( ) {
            if ( $( this ).hasClass( 'disabled' ) == false ) {
                paste_to_this_dir( );
            }
        });

        $( '.clipboard-clear-btn' ).on( 'click', function ( ) {
            if ( $( this ).hasClass( 'disabled' ) == false ) {
                clipboard_clear( );
            }
        });

        // reverted to jquery from Modernizr.csstransforms because drag&drop
        if ( !Modernizr.csstransforms ) {
            // Test if CSS transform are supported
            var figures = $( 'figure' );

            figures.on( 'mouseover', function ( ) {
                if ( config.view == 0 && $( '#main-item-container' ).hasClass( 'no-effect-slide' ) === false ) {
                    $( this ).find( '.box:not(.no-effect)' ).animate({ top: '-26px' }, {
                        queue: false,
                        duration: 300
                    });
                }
            });

            figures.on( 'mouseout', function ( ) {
                if ( config.view == 0 ) {
                    $( this ).find( '.box:not(.no-effect)' ).animate({ top: '0px' }, {
                        queue: false,
                        duration: 300
                    });
                }
            });
        }

        $( window ).resize( function ( ) {
            fix_colums( 28 );
        });

        fix_colums( 14 );
        toggle_clipboard( config.clipboard );

        // Drag & Drop
        $( 'li.dir, li.file' ).draggable({
            distance: 20,
            cursor: "move",

            helper: function ( ) {
                //hack all the way through
                $( this ).find( 'figure' ).find( '.box' ).css( "top", "0px" );
                var ret = $( this ).clone( ).css( 'z-index', 1000 ).find( '.box' ).css( 'box-shadow', 'none' ).css( '-webkit-box-shadow', 'none' ).parent( ).parent( );
                $(this).addClass('selected');
                return ret;
            },

            start: function ( ) {
                if ( config.view == 0 ) {
                    $( '#main-item-container' ).addClass( 'no-effect-slide' );
                }
            },

            stop: function ( ) {
                $(this).removeClass('selected');

                if ( config.view == 0 ) {
                    $( '#main-item-container' ).removeClass( 'no-effect-slide' );
                }
            }
        });

        $( 'li.dir, li.back' ).droppable({
            accept: 'ul.grid li',
            activeClass: 'ui-state-highlight',
            hoverClass: 'ui-state-hover',
            drop: function ( event, ui ) {
                drag_n_drop_paste( ui.draggable.find( 'figure' ), $( this ).find( 'figure' ) );
            }
        });

        // file permissions window
        $( document ).on( 'keyup', '#chmod_form #chmod_value', function ( ) {
            chmod_logic( true );
        });

        //safety
        $( document ).on( 'focusout', '#chmod_form #chmod_value', function ( ) {
            var chmodElement = $('#chmod_form #chmod_value');

            if ( chmodElement.val( ).match( /^[0-7]{3}$/ ) == null ) {
                chmodElement.val( chmodElement.attr( 'data-def-value' ) );
                chmod_logic( true );
            }
        });
    });

    function preview_loading_animation ( url ) {
        show_animation( );
        var tmpImg = new Image( );
        tmpImg.src = url;

        $( tmpImg ).on( 'load',function( ){
            hide_animation( );
        });
    }

    function create_text_file ( ) {
        // remove to prevent duplicates
        $( '#textfile_create_area' ).parent( ).parent( ).remove( );

        var init_form = config.languages.filename + ': <input type="text" id="create_text_file_name" style="min-height:30px"><br><hr><textarea id="textfile_create_area" style="width:100%;height:150px;"></textarea>';

        bootbox.dialog( init_form, [
            {
                'label': $('#lang_cancel').val(),
                'class': 'btn'
            }, {
                'label': config.languages.ok,
                'class': 'btn-inverse',
                'callback': function ( ) {
                    var url              = config.urls.create_file;
                    var new_file_name    = $( '#create_text_file_name' ).val( );
                    var new_file_content = $( '#textfile_create_area' ).val( );

                    if ( new_file_name !== null ) {
                        new_file_name           = fix_filename( new_file_name );
                        var source_path         = config.current_directory + config.current_folder + new_file_name;
                        var source_cache_path   = config.current_cache_directory + new_file_name;

                        // post ajax
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                name: new_file_name,
                                content: new_file_content,
                                source_path: source_path,
                                source_cache_path: source_cache_path
                            }
                        }).done( function ( msg ) {
                            if ( msg != '' ) {
                                bootbox.alert( msg, function ( /*result*/ ) {
                                    setTimeout( function ( ) {
                                        window.location.href = $( '#refresh' ).attr( 'href' );
                                    }, 500 );
                                });
                            }
                        });
                    }
                }
            }
        ], {
            'header': config.languages.new_file
        });
    }

    function edit_text_file ( $trigger ) {
        // remove to prevent duplicates
        $( '#textfile_edit_area' ).closest( '.modal' ).remove( );

        var url                 = config.urls.edit_text;
        var source_path         = $trigger.attr('data-source-path' );
        var source_cache_path   = $trigger.attr( 'data-source-cache-path' );

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                mode: 'text',
                source_path: source_path,
                source_cache_path: source_cache_path
            }
        }).done( function ( init_content ) {
            bootbox.dialog( init_content, [
                {
                    'label': config.languages.cancel,
                    'class': 'btn'
                }, {
                    'label': config.languages.ok,
                    'class': 'btn-inverse',
                    'callback': function ( ) {
                        var url = config.urls.save_text,
                            content = $( '#textfile_edit_area' ).val( );

                        // post ajax
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                source_path: source_path,
                                source_cache_path: source_cache_path,
                                content: content
                            }
                        }).done( function ( status_msg ) {
                            if ( status_msg != '' ) {
                                bootbox.alert( status_msg );
                            }
                        });
                    }
                }
            ], {
                'header': $trigger.find( '.name_download' ).val( )
            });
        });
    }

    function chmod ( $trigger ) {
        // remove to prevent duplicates
        $( '#files_permission_start' ).parent( ).parent( ).remove( );

        var url = config.urls.chmod, source_path, source_cache_path;

        source_path         = $trigger.attr( 'data-source-path' );
        source_cache_path   = $trigger.attr( 'data-source-cache-path' );

        // ajax -> box -> ajax -> box -> mind blown
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                source_path: source_path,
                source_cache_path: source_cache_path
            }
        }).done( function ( init_msg ) {
            bootbox.dialog( init_msg, [
                {
                    'label': config.languages.cancel,
                    'class': 'btn'
                }, {
                    'label': config.languages.ok,
                    'class': 'btn-inverse',
                    'callback': function ( ) {
                        // get new perm
                        var url  = config.urls.save_mode,
                            mode = $( '#chmod_form #chmod_value' ).val( );

                        if ( mode != '' && typeof mode !== 'undefined' ) {
                            // get recursive option if any
                            var rec_option = $( '#chmod_form input[name=apply_recursive]:checked' ).val( );
                            if ( rec_option == '' || typeof rec_option === 'undefined' ) {
                                rec_option = 'none';
                            }

                            // post ajax
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    mode: mode,
                                    rec_option: rec_option,
                                    source_path: source_path,
                                    source_cache_path: source_cache_path
                                }
                            }).done( function ( status_msg ) {
                                if ( status_msg != '' ) {
                                    bootbox.alert( status_msg );
                                }
                            });
                        }
                    }
                }
            ], {
                'header': config.languages.file_permission
            });
        });
    }

    function clipboard_clear ( ) {
        bootbox.confirm( config.languages.clipboard_clear_confirm, config.languages.cancel, config.languages.ok, function ( result ) {
            if ( result == true ) {
                $.ajax({
                    url: config.urls.clipboard_clear,
                    type: 'POST',
                    data: {}
                }).done( function ( msg ) {
                    if ( msg != '' ) {
                        bootbox.alert( msg );
                    } else {
                        $( '#clipboard' ).val( '0' );
                    }
                    toggle_clipboard( false );
                });
            }
        });
    }

    function copy_cut_clicked ( $trigger, atype ) {
        if ( atype != 'copy' && atype != 'cut' ) {
            return;
        }

        if ( atype == 'cut' ) {
            var url = config.urls.clipboard_cut;
        } else {
            var url = config.urls.clipboard_copy;
        }

        var source_path         = $trigger.attr( 'data-source-path' ),
            source_cache_path   = $trigger.attr( 'data-source-cache-path' );

        $.ajax({
            type: "POST",
            url: url,
            data: {
                source_path: source_path,
                source_cache_path: source_cache_path
            }
        }).done( function ( msg ) {
            if ( msg != '' ) {
                bootbox.alert( msg );
            } else {
                $( '#clipboard' ).val( '1' );
                toggle_clipboard( true );
            }
        });
    }

    function paste_to_this_dir ( dnd ) {
        bootbox.confirm( config.languages.paste_confirm, config.languages.cancel, config.languages.ok, function ( result ) {
            if ( result == true ) {
                var url = config.urls.clipboard_paste, source_path, source_cache_path;

                if ( typeof dnd != 'undefined' ) {
                    source_path         = dnd.attr( 'data-source-path' );
                    source_cache_path   = dnd.attr( 'data-source-cache-path' );
                } else {
                    source_path         = config.current_directory;
                    source_cache_path   = config.current_cache_directory;
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        source_path: source_path,
                        source_cache_path: source_cache_path
                    }
                }).done( function ( msg ) {
                    if ( msg != '' ) {
                        bootbox.alert(msg);
                    } else {
                        $( '#clipboard' ).val( '0' );
                        toggle_clipboard( false );

                        setTimeout( function ( ) {
                            window.location.href = $( '#refresh' ).attr( 'href' );
                        }, 300 );
                    }
                });
            }
        });
    }

    // Had to separate from copy_cut_clicked & paste_to_this_dir func
    // because of feedback and on error bahhhhh...
    function drag_n_drop_paste ( $trigger, dnd ) {
        var url                 = config.urls.clipboard_cut,
            source_path         = $trigger.attr( 'data-source-path' ),
            source_cache_path   = $trigger.attr( 'data-source-cache-path' );

        $trigger.closest( 'li' ).hide( 100 );

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                source_path: source_path,
                source_cache_path: source_cache_path,
            }
        }).done( function ( msg ) {
            if ( msg != '' ) {
                bootbox.alert( msg );
            } else {
                var url = config.urls.clipboard_paste, source_path, source_cache_path;

                if ( typeof dnd != 'undefined' ) {
                    if ( dnd.hasClass( 'back-directory' ) ) {
                        source_path         = dnd.find( '.data-source-path' ).val( );
                        source_cache_path   = dnd.find( '.data-source-cache-path' ).val( );
                    } else {
                        source_path         = dnd.attr( 'data-source-path' );
                        source_cache_path   = dnd.attr( 'data-source-cache-path' );
                    }
                } else {
                    source_path         = config.current_directory;
                    source_cache_path   = config.current_cache_directory
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        source_path: source_path,
                        source_cache_path: source_cache_path
                    }
                }).done( function ( msg ) {
                    if ( msg != '' ) {
                        bootbox.alert( msg );
                        $trigger.closest( 'li' ).show( 100 );
                    } else {
                        $( '#clipboard' ).val( '0' );
                        toggle_clipboard( false );
                        $trigger.closest( 'li' ).remove( );
                    }
                });
            }
        }).error( function ( /*err*/ ) {
            $trigger.closest( 'li' ).show( 100 );
        });
    }

    function toggle_clipboard ( lever ) {
        if ( lever == true ) {
            $( '.clipboard-paste-btn, .clipboard-clear-btn' ).removeClass( 'disabled' );
        } else {
            $( '.clipboard-paste-btn, .clipboard-clear-btn' ).addClass( 'disabled' );
        }
    }

    function fix_colums ( adding ) {
        var width       = $( '.breadcrumb' ).width( ) + adding;
        var help_element = $( '#help' );

        $( '.uploader' ).css( 'width', width );

        if ( config.view > 0 ) {
            if ( config.view == 1 ) {
                $( 'ul.grid li, ul.grid figure' ).css( 'width', '100%' );
            } else {
                var col = Math.floor( width / 380 );

                if ( col == 0 ) {
                    col = 1;
                    $( 'h4' ).css( 'font-size', 12 );
                }

                width = Math.floor( ( width / col ) - 3 );

                $( 'ul.grid li, ul.grid figure' ).css( 'width', width );
            }

            help_element.hide( );
        } else {
            if ( Modernizr.touch ) {
                help_element.show( );
            }
        }
    }

    function swipe_reaction ( /*event, direction, distance, duration, fingerCount*/ ) {
        var _this = $( this );

        if ( config.view == 0 ) {
            if ( _this.attr( 'toggle' ) == 1 ) {
                _this.attr( 'toggle', 0 );
                _this.animate({ top: '0px' }, {
                    queue: false,
                    duration: 300
                });
            } else {
                _this.attr( 'toggle', 1 );
                _this.animate({ top: '-30px' }, {
                    queue: false,
                    duration: 300
                });
            }
        }
    }

    encodeURL = function ( url ) {

        if ( typeof url !== 'undefined' ) {
            var tmp = url.split( '/' );

            for ( var i = 3; i < tmp.length; i++ ) {
                tmp[i] = encodeURIComponent( tmp[i] );
            }

            url = tmp.join( '/' );
        }

        return url;

    }

    apply = function ( file, file_url, external ) {
        var window_parent;

        if ( config.popup ) {
            window_parent = window.opener;
        } else {
            window_parent = window.parent;
        }

        var url                     = encodeURL( file_url );
        var fill                    = '';
        var filename                = file.substr( 0, file.lastIndexOf( '.' ) );
        var extension               = file.split( '.' ).pop( ); extension = extension.toLowerCase( );

        if ( external != '' ) {
            if ( config.crossdomain ) {
                window_parent.postMessage({
                    sender: 'filemanager',
                    url: url,
                    field_id: external
                }, '*' );
            } else {
                var target = $( '#' + external, window_parent.document );
                target.val( url ).trigger( 'change' );

                if ( typeof window_parent.filemanager_callback == 'function' ) {
                    window_parent.filemanager_callback( external );
                }
                close_window( );
            }
        } else {
            if ( $.inArray( extension, config.extensions.images ) > -1 ) {
                fill = '<img src="' + url + '" alt="' + filename + '" />';
            } else {
                if ( $.inArray( extension, config.extensions.videos ) > -1 ) {
                    fill = '<video controls source src="' + url + '" type="video/' + extension + '">' + filename + '</video>';
                } else {
                    if ( $.inArray( extension, config.extensions.images ) > -1 ) {
                        if ( extension == 'mp3' ) {
                            extension = 'mpeg';
                        }
                        fill = '<audio controls src="' + url + '" type="audio/' + extension + '">' + filename + '</audio>';
                    } else {
                        fill = '<a href="' + url + '" title="' + filename + '">' + filename + '</a>';
                    }
                }
            }

            if ( config.crossdomain ) {
                window_parent.postMessage({
                    sender: 'filemanager',
                    url: url,
                    field_id: null,
                    html: fill
                }, '*' );
            } else {
                if ( parent.tinymce.majorVersion < 4 ) {
                    // tinymce 3.X
                    parent.tinymce.activeEditor.execCommand( 'mceInsertContent', false, fill );
                    parent.tinymce.activeEditor.windowManager.close( parent.tinymce.activeEditor.windowManager.params.mce_window_id );
                } else {
                    // tinymce 4.X
                    parent.tinymce.activeEditor.insertContent( fill );
                    parent.tinymce.activeEditor.windowManager.close( );
                }
            }
        }
    }

    apply_link = function ( file, file_url, external ) {
        var window_parent;

        if ( config.popup ) {
            window_parent = window.opener;
        } else {
            window_parent = window.parent;
        }

        var url                     = encodeURL( file_url );
        var fill                    = '';
        var filename                = file.substr( 0, file.lastIndexOf( '.' ) );
        var extension               = file.split( '.' ).pop( ); extension = extension.toLowerCase( );

        if ( external != '' ) {
            if ( config.crossdomain ) {
                window_parent.postMessage({
                    sender: 'filemanager',
                    url: url,
                    field_id: external
                }, '*' );
            } else {
                var target = $( '#' + external, window_parent.document );
                target.val( url ).trigger( 'change' );

                if ( typeof window_parent.filemanager_callback == 'function' ) {
                    window_parent.filemanager_callback( external );
                }

                close_window( );
            }
        } else {
            apply_any( url );
        }
    }

    apply_img = function ( file, file_url, external ) {
        var window_parent;

        if ( config.popup ) {
            window_parent = window.opener;
        } else {
            window_parent = window.parent;
        }

        var url                     = encodeURL( file_url );
        var fill                    = '';
        var filename                = file.substr( 0, file.lastIndexOf( '.' ) );
        var extension               = file.split( '.' ).pop( ); extension = extension.toLowerCase( );

        if ( external != '' ) {
            if ( config.crossdomain ) {
                window_parent.postMessage({
                    sender: 'filemanager',
                    url: url,
                    field_id: external
                }, '*' );
            } else {
                var target = $( '#' + external, window_parent.document );
                target.val( url ).trigger( 'change' );

                if ( typeof window_parent.filemanager_callback == 'function' ) {
                    window_parent.filemanager_callback( external );
                }

                close_window( );
            }
        } else {
            apply_any( url );
        }
    }

    apply_video = function ( file, file_url, external ) {
        var window_parent;

        if ( config.popup ) {
            window_parent = window.opener;
        } else {
            window_parent = window.parent;
        }

        var url                     = encodeURL( file_url );
        var fill                    = '';
        var filename                = file.substr( 0, file.lastIndexOf( '.' ) );
        var extension               = file.split( '.' ).pop( ); extension = extension.toLowerCase( );

        if ( external != '' ) {
            if ( config.crossdomain ) {
                window_parent.postMessage({
                    sender: 'filemanager',
                    url: url,
                    field_id: external
                }, '*' );
            } else {
                var target = $( '#' + external, window_parent.document );
                target.val( url ).trigger( 'change' );

                if ( typeof window_parent.filemanager_callback == 'function' ) {
                    window_parent.filemanager_callback( external );
                }

                close_window( );
            }
        } else {
            apply_any( url );
        }
    }

    apply_none = function ( file/*, external*/ ) {
        var _this = $( 'ul.grid' ).find( 'li[data-file="' + file + '"] figcaption a' );
        _this[1].click( );

        $( '.tip-right' ).tooltip( 'hide' );
    }

    function getUrlParam ( param_name ) {
        var reg_param   = new RegExp( '(?:[\?&]|&)' + param_name + '=([^&]+)', 'i' );
        var match       = window.location.search.match( reg_param );

        return ( match && match.length > 1 ) ? match[ 1 ] : null;
    }

    apply_any = function ( url ) {
        if ( config.crossdomain ) {
            window.parent.postMessage({
                sender: 'filemanager',
                url: url,
                field_id: null
            }, '*' );
        } else {
            if ( config.editor == 'ckeditor' ) {
                var funcNum = getUrlParam( 'CKEditorFuncNum' );
                window.opener.CKEDITOR.tools.callFunction( funcNum, url );
                window.close( );
            } else {
                if ( parent.tinymce.majorVersion < 4 ) {
                    // tinymce 3.X
                    parent.tinymce.activeEditor.windowManager.params.setUrl( url );
                    parent.tinymce.activeEditor.windowManager.close( parent.tinymce.activeEditor.windowManager.params.mce_window_id );
                } else {
                    // tinymce 4.X
                    parent.tinymce.activeEditor.windowManager.getParams( ).setUrl( url );
                    parent.tinymce.activeEditor.windowManager.close( );
                }
            }
        }
    }

    function close_window ( ) {
        if ( config.popup ) {
            window.close( );
        } else {
            parent.$( '.modal' ).modal( 'hide' );

            if ( typeof parent.jQuery !== 'undefined' && parent.jQuery ) {
                if ( typeof parent.jQuery.fancybox == 'function' ) {
                    parent.jQuery.fancybox.close( );
                }
            } else {
                if ( typeof parent.$.fancybox == 'function' ) {
                    parent.$.fancybox.close( );
                }
            }
        }
    }

    apply_file_duplicate = function ( container, name ) {
        var li_container = container.parent( ).parent( ).parent( ).parent( );

        li_container.after( "<li class='" + li_container.attr( 'class' ) + "' data-file='" + li_container.attr( 'data-file' ) + "'>" + li_container.html( ) + "</li>" );

        var cont = li_container.next( );

        apply_file_rename( cont.find( 'figure' ), name );

        var form = cont.find( '.download-form' );
        var new_form_id = 'form' + new Date( ).getTime( );

        form.attr( 'id', new_form_id );
        form.find( '.tip-right' ).attr( 'onclick', "$('#" + new_form_id + "').submit();" );
    }

    apply_file_rename = function ( container, name ) {
        var file;

        container.attr( 'data-file', name );
        container.parent( ).attr( 'data-file', name );
        container.find( 'h4' ).find( 'a' ).text( name );

        //select link
        var link = container.find( 'a.link' );

        file = link.attr( 'data-file' );

        var old_name    = file.substring( file.lastIndexOf( '/' ) + 1 );
        var extension   = file.substring( file.lastIndexOf( '.' ) + 1 );

        link.each( function ( ) {
            $( this ).attr( 'data-file', encodeURIComponent( name + '.' + extension ) );
        });

        //thumbnails
        container.find( 'img' ).each( function ( ) {
            var src = $( this ).attr( 'src' );

            $( this ).attr( 'src', src.replace( old_name, name + '.' + extension ) + '?time=' + new Date( ).getTime( ) );
            $( this ).attr( 'alt', name + ' thumbnails' );
        });

        //preview link
        var link2 = container.find( 'a.preview-btn' );
        file = link2.attr( 'data-file-url' );

        if ( typeof file !== 'undefined' && file ) {
            link2.attr( 'data-file-url', file.replace( encodeURIComponent( old_name ), encodeURIComponent( name + '.' + extension ) ) );
        }

        //li data-file
        container.parent( ).attr( 'data-file', name + '.' + extension );
        container.attr( 'data-file', name + '.' + extension );

        //download link
        container.find( '.name_download' ).val( name + '.' + extension );

        //rename link && delete link
        var link3 = container.find( 'a.rename-file-btn' );
        var link4 = container.find( 'a.delete-file-btn' );

        var path_old    = link3.attr( 'data-path' );
        var path_thumb  = link3.attr( 'data-thumb' );
        var new_path    = path_old.replace( old_name, name + '.' + extension );
        var new_thumb   = path_thumb.replace( old_name, name + '.' + extension );

        link3.attr( 'data-path', new_path );
        link3.attr( 'data-thumb', new_thumb );
        link4.attr( 'data-path', new_path );
        link4.attr( 'data-thumb', new_thumb );
    }

    apply_folder_rename = function ( container, name ) {
        container.attr( 'data-file', name );
        container.find( 'figure' ).attr( 'data-file', name );

        var old_name = container.find( 'h4' ).find( 'a' ).text( );
        container.find( 'h4 > a' ).text( name );

        //select link
        var link    = container.find( '.folder-link' );
        var url     = link.attr( 'href' );
        var fldr    = $( '#fldr_value' ).val( );
        var new_url = url.replace( 'fldr=' + fldr + encodeURIComponent( old_name ), 'fldr=' + fldr + encodeURIComponent( name ) );

        link.each( function ( ) {
            $( this ).attr( 'href', new_url );
        });

        //rename link && delete link
        var link2       = container.find( 'a.delete-folder' );
        var link3       = container.find( 'a.rename-folder-btn' );
        var path_old    = link3.attr( 'data-path' );
        var thumb_old   = link3.attr( 'data-thumb' );

        var index       = path_old.lastIndexOf('/');
        var new_path    = path_old.substr( 0, index + 1 ) + name;
        link2.attr( 'data-path', new_path );
        link3.attr( 'data-path', new_path );

        var index       = thumb_old.lastIndexOf( '/' );
        var new_path    = thumb_old.substr( 0, index + 1 ) + name;
        link2.attr( 'data-thumb', new_path );
        link3.attr( 'data-thumb', new_path );
    }

    function replace_last ( str, find, replace ) {
        var re = new RegExp( find + '$' );
        return str.replace( re, replace );
    }

    function replaceDiacritics ( s ) {
        var s;

        var diacritics = [
            /[\300-\306]/g, /[\340-\346]/g,  // A, a
            /[\310-\313]/g, /[\350-\353]/g,  // E, e
            /[\314-\317]/g, /[\354-\357]/g,  // I, i
            /[\322-\330]/g, /[\362-\370]/g,  // O, o
            /[\331-\334]/g, /[\371-\374]/g,  // U, u
            /[\321]/g, /[\361]/g, // N, n
            /[\307]/g, /[\347]/g // C, c
        ];

        var chars = ['A', 'a', 'E', 'e', 'I', 'i', 'O', 'o', 'U', 'u', 'N', 'n', 'C', 'c'];

        for ( var i = 0; i < diacritics.length; i++ ) {
            s = s.replace( diacritics[i], chars[i] );
        }

        return s;
    }

    function fix_filename ( stri ) {
        if ( stri != null ) {
            if ( config.transliteration ) {
                stri = replaceDiacritics( stri );
                stri = stri.replace( /[^A-Za-z0-9\.\-\[\] _]+/g, '' );
            }

            if ( config.convert_spaces ) {
                stri = stri.replace( / /g, config.replace_with );
                stri = stri.toLowerCase();
            }

            stri = stri.replace( '', '' );
            stri = stri.replace( "'", '' );
            stri = stri.replace( "/", '' );
            stri = stri.replace( "\\", '' );
            stri = stri.replace( /<\/?[^>]+(>|$)/g, '' );

            return $.trim( stri );
        }

        return null;
    }

    function execute_action ( url, source_path, source_cache_path, name, container, function_name ) {

        if ( typeof name !== 'undefined' ) {
            name = fix_filename( name );
            name.replace( '/', '' );
        }

        $.ajax({
            type: "POST",
            url: url,
            data: {
                name: name,
                source_path: source_path,
                source_cache_path: source_cache_path
            }
        }).done( function ( msg ) {

            if ( msg != '' ) {
                bootbox.alert( msg );
                return false;
            } else {
                if ( typeof function_name !== 'undefined'  ) {
                    window[function_name]( container, name );
                }
            }

            return true;
        });
    }

    function sortUnorderedList ( sort_order, sort_field ) {
        var lis_dir     = $( 'li.dir', 'ul.grid' ).filter( ':visible' );
        var lis_file    = $( 'li.file', 'ul.grid' ).filter( ':visible' );

        var vals_dir    = [];
        var values_dir  = [];
        var vals_file   = [];
        var values_file = [];

        lis_dir.each( function ( index ) {
            var _this = $( this );
            var value = _this.find( sort_field ).val( );

            if ( $.isNumeric( value ) ) {
                value = parseFloat( value );

                while ( typeof vals_dir[value] !== 'undefined' && vals_dir[value] ) {
                    value = parseFloat( parseFloat( value ) + parseFloat( 0.001 ) );
                }
            } else {
                value = value + "a" + _this.find( 'h4 a' ).attr( 'data-file' );
            }

            vals_dir[value] = _this.html( );
            values_dir.push( value );
        });

        lis_file.each( function ( index ) {
            var _this = $( this );
            var value = _this.find( sort_field ).val( );

            if ( $.isNumeric( value ) ) {
                value = parseFloat( value );

                while ( typeof vals_file[value] !== 'undefined' && vals_file[value] ) {
                    value = parseFloat( parseFloat( value ) + parseFloat( 0.001 ) );
                }
            } else {
                value = value + "a" + _this.find( 'h4 a' ).attr( 'data-file' );
            }

            vals_file[value] = _this.html( );
            values_file.push( value  );
        });

        if ( $.isNumeric( values_dir[0] ) ) {
            values_dir.sort( function ( a, b ) {
                return parseFloat( a ) - parseFloat( b );
            });
        } else {
            values_dir.sort( );
        }

        if ( $.isNumeric( values_file[0] ) ) {
            values_file.sort( function ( a, b ) {
                return parseFloat( a ) - parseFloat( b );
            });
        } else {
            values_file.sort( );
        }

        if ( sort_order ) {
            values_dir.reverse( );
            values_file.reverse( );
        }

        lis_dir.each( function ( index ) {
            var _this = $( this );
            _this.html( vals_dir[values_dir[index]] );
        });

        lis_file.each( function ( index ) {
            var _this = $( this );
            _this.html( vals_file[values_file[index]] );
        });
    }

    show_animation = function ( ) {
        $( '#loading_container' ).css( 'display', 'block' );
        $( '#loading' ).css( 'opacity', '.7' );
    }

    hide_animation = function ( ) {
        $( '#loading_container' ).fadeOut( );
    }

    function launchEditor ( id, src ) {
        ImageEditor.launch({
            image: id,
            url: src
        });

        return false;
    }

    // Reset generale lazyload altrimenti sul sort non riparte
    function lazyLoad ( ) {
        $( '.lazy-loaded' ).lazyload( );
    }

})( jQuery, Modernizr );

function chmod_logic ( is_text ) {
    var permission      = [];
    permission['user']  = 0;
    permission['group'] = 0;
    permission['all']   = 0;

    // value was set by text input
    if ( typeof is_text !== 'undefined' && is_text == true ) {
        // assign values
        var new_permission  = $( '#chmod_form #chmod_value' ).val( );
        permission['user']  = new_permission.substr( 0, 1 );
        permission['group'] = new_permission.substr( 1, 1 );
        permission['all']   = new_permission.substr( 2, 1 );

        // check values for errors (empty,not num, not 0-7)
        $.each( permission, function ( index ) {
            if (permission[ index ] == '' ||
                $.isNumeric(permission[index]) == false ||
                ( parseInt( permission[index] ) < 0 || parseInt( permission[index] ) > 7 ) ) {
                permission[index] = "0";
            }
        });

        // update checkboxes
        $( '#chmod_form input:checkbox' ).each( function ( ) {
            var group   = $( this ).attr( 'data-group' );
            var value   = $( this).attr( 'data-value' );

            if ( chmod_logic_helper( permission[group], value ) ) {
                $( this ).prop( 'checked', true );
            } else {
                $( this ).prop( 'checked', false );
            }
        });
    } else {
        //a checkbox was updated
        $( '#chmod_form input:checkbox:checked' ).each( function ( ) {
            var group   = $( this ).attr( 'data-group' );
            var value   = $( this ).attr( 'data-value' );
            permission[group] = parseInt( permission[group] ) + parseInt( value );
        });

        $( '#chmod_form #chmod_value' ).val( permission['user'].toString( ) + permission['group'].toString( ) + permission['all'].toString( ) );
    }
}

function chmod_logic_helper ( permission, value ) {
    var valid = [];
    valid[1]  = [1, 3, 5, 7];
    valid[2]  = [2, 3, 6, 7];
    valid[4]  = [4, 5, 6, 7];

    value       = parseInt( value );
    permission  = parseInt( permission );

    return ( $.inArray( permission, valid[value] ) != -1 );
}