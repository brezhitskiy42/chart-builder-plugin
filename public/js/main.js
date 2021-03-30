jQuery(document).ready(function($) {
  
  'use strict';
  
  // Replacing standard range input
  replaceRangeInput();
  
  function replaceRangeInput() {
    $('.cb-field input[type="range"]').rangeslider({
      polyfill: false,
      onSlide: function(position, value) { $(this.$element).siblings('.cb-alpha-number').text(value); }
    });
  }
  
  // Resetting forms
  $('#cb-reset').on('click', function() {
    
    var $error = $('.cb-fail'),
        $charts = $('.cb-chart'),
        $settings = $('.cb-settings');
    
    $error.hide();
    
    $charts.remove();
    $('#cb-add-more').trigger('click');
    
    $settings.find('#background').get(0).jscolor.fromString('ffffff');
    $settings.find('#grid-lines-color').get(0).jscolor.fromString('eeeeee');
    $settings.find('#grid-lines-color-alpha').val(1).change();
    $settings.find('#line-thickness').val(1).change();
    $settings.find('#background-logo').val('');
    $settings.find('#background-logo-alpha').val(1).change();
    $settings.find('#display-volume').prop('checked', true);
    
    if (chart) {
      chart.clear();
      chart = null;
    }
    
  });
  
  // Resizing chart series
  resizeChartSeries();
  $(window).on('resize', resizeChartSeries);
  
  function resizeChartSeries() {
    
    var $chartSeries = $('.cb-chart-series'),
        chartSeriesWidth = $chartSeries.width(),
        $charts = $chartSeries.find('.cb-chart'),
        $settings = $('.cb-settings');
    
    if (chartSeriesWidth < 250) {
      $.each($charts, function() {
        var $fields = $(this).find('.cb-field');
        if ($fields.length === 8) {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '100%'); break;
              case 1: $(this).css('width', '100%'); break;
              default: $(this).css('width', '48%');
            }
          });
        } else {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '100%'); break;
              case 1: $(this).css('width', '100%'); break;
              default: $(this).css('width', '48%');
            }
          });
        }
      });
      $.each($settings, function() {
        var $fields = $(this).find('.cb-field');
        $.each($fields, function(i) {
          switch(i) {
            case 6: $(this).css('width', '100%'); break;
            default: $(this).css('width', '48%');
          }
        });
      });
    } else if (chartSeriesWidth < 375) {
      $.each($charts, function() {
        var $fields = $(this).find('.cb-field');
        if ($fields.length === 8) {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '48%'); break;
              case 1: $(this).css('width', '48%'); break;
              default: $(this).css('width', '24%');
            }
          });
        } else {
          $.each($fields, function(i) {
            switch(i) {
              case 1: $(this).css('width', '72%'); break;
              default: $(this).css('width', '24%');
            }
          });
        }
      });
      $.each($settings, function() {
        var $fields = $(this).find('.cb-field');
        $.each($fields, function(i) {
          switch(i) {
            case 6: $(this).css('width', '100%'); break;
            default: $(this).css('width', '48%');
          }
        });
      });
    } else if (chartSeriesWidth < 500) {
      $.each($charts, function() {
        var $fields = $(this).find('.cb-field');
        if ($fields.length === 8) {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '24%'); break;
              case 1: $(this).css('width', '48%'); break;
              case 2: $(this).css('width', '24%'); break;
              default: $(this).css('width', '19%');
            }
          });
        } else {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '21%'); break;
              case 1: $(this).css('width', '32%'); break;
              case 2: $(this).css('width', '21%'); break;
              case 2: $(this).css('width', '21%'); break;
              default: $(this).css('width', '19%');
            }
          });
        }
      });
      $.each($settings, function() {
        var $fields = $(this).find('.cb-field');
        $.each($fields, function(i) {
          switch(i) {
            case 6: $(this).css('width', '100%'); break;
            default: $(this).css('width', '32%');
          }
        });
      });
    } else if (chartSeriesWidth < 900) {
      $.each($charts, function() {
        var $fields = $(this).find('.cb-field');
        if ($fields.length === 8) {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '24%'); break;
              case 1: $(this).css('width', '48%'); break;
              case 2: $(this).css('width', '24%'); break;
              default: $(this).css('width', '19%');
            }
          });
        } else {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '21%'); break;
              case 1: $(this).css('width', '32%'); break;
              case 2: $(this).css('width', '21%'); break;
              case 2: $(this).css('width', '21%'); break;
              default: $(this).css('width', '19%');
            }
          });
        }
      });
      $.each($settings, function() {
        var $fields = $(this).find('.cb-field');
        $.each($fields, function(i) {
          switch(i) {
            case 0: $(this).css('width', '20%'); break;
            case 1: $(this).css('width', '20%'); break;
            case 3: $(this).css('width', '24%'); break;
            default: $(this).css('width', '32%');
          }
        });
      });
    } else {
      $.each($charts, function() {
        var $fields = $(this).find('.cb-field');
        if ($fields.length === 8) {
          $.each($fields, function(i) {
            switch(i) {
              case 0: $(this).css('width', '13%'); break;
              case 1: $(this).css('width', '20%'); break;
              case 3: $(this).css('width', '7%'); break;
              default: $(this).css('width', '10%');
            }
          });
        } else {
          $.each($fields, function(i) {
            switch(i) {
              case 1: $(this).css('width', '13%'); break;
              case 2: $(this).css('width', '12%'); break;
              default: $(this).css('width', '10%');
            }
          });
        }
      });
      $.each($settings, function() {
        var $fields = $(this).find('.cb-field');
        $.each($fields, function(i) {
          switch(i) {
            case 6: $(this).css('width', '100%'); break;
            default: $(this).css('width', '15%');
          }
        });
      });
    }
    
    $('.cb-field input[type="range"]').rangeslider('update', true);
    
  }
  
  // Removing chart
  $('body').on('click', '.cb-remove', function() { $(this).parent().remove(); });
  
  // Adding new chart
  $('#cb-add-more').on('click', function() {
    
    var self = this;
    
    var data = { action: 'add_more_chart', nonce_code: ajaxcb.nonce };
    
    $.post(ajaxcb.url, data, function(res) {
      
      if (+res === -1) return;
      
      var chart = $(res).insertBefore(self);
      replaceRangeInput();
      resizeChartSeries();
      jscolor.installByClassName('jscolor');
      addNewAutocomplete(chart);
      
    });
    
  });
  
  // Autocomplete
  var tickers = initAutocomplete();
  
  function initAutocomplete() {
    
    var tickers = {};
    
    $.each($('input[name="ticker"]'), function() {
      var self = this;
      var ticker = new Awesomplete(this, {
        minChars: 1,
        maxItems: 999,
        list: [],
        sort: false,
        item: function(text, input, item_id) {
          var status = (!text.quandl_status || text.quandl_status === 'free') ? '' : 'Premium';
          var html = input.trim() === '' ? text : '<div class="awesomplete-symbol-source"><div class="awesomplete-symbol">' + text.value + '</div></div><div class="awesomplete-value-status"><div class="awesomplete-value">' + text.label + '</div><div class="awesomplete-status">' + status + '</div></div>';
          return createEl('li', {
            innerHTML: html,
            'aria-selected': 'false',
            id: 'awesomplete_list_' + this.count + '_item_' + item_id
          });
        },
        replace: function(text) {
          if (text.source === 'quandl') {
            this.input.value = text.value;
            this.input.dataset.value = text.label + '/' + text.quandl_value;
          } else {
            this.input.value = text.label;
            this.input.dataset.value = text.value;
          }
        },
        filter: function(text, input) {        
          if (text.source === 'crypto') {
            return RegExp(regExpEscape(input.trim()), 'i').test(text.label) || RegExp(regExpEscape(input.trim()), 'i').test(text.value);
          }
          return true;
        }
      });
      
      document.getElementById($(this).attr('id')).addEventListener('awesomplete-selectcomplete', function(e) {
        
        var value = e.text.value,
            source = e.text.source,
            quandl_type = e.text.quandl_type,
            $chart = $(self).closest('.cb-chart'),
            $columnNamesBlock = $chart.find('.cb-column-names'),
            $columnNames = $chart.find('select[name="column_names"]');
        
        if (source === 'quandl') {
          value = e.text.label + '/' + e.text.quandl_value;
        }
        
        $chart.find('input[name="ticker_symbol"]').val(value);
        $columnNames.find('option').remove();
        $columnNamesBlock.removeClass('cb-field').hide();
        resizeChartSeries();
        
        if (source === 'quandl') {
          
          $chart.find('input[name="quandl_type"]').val(quandl_type);
          
          var codes = e.text.label + '/' + e.text.quandl_value;
          
          var data = { 
            nonce_code: ajaxcb.nonce,
            action: 'load_quandl_column_names',
            codes: codes
          };
          
          $.post(ajaxcb.url, data, function(res) {
            
            if (+res === -1) {
              return;
            }
            
            var columnNames = JSON.parse(res);
            
            columnNames.forEach(function(column, i) {
              var selected = (i === 0) ? ' selected' : '';
              $columnNames.append($('<option'+ selected +'></option>').attr('value', i + 1).text(column));
            });
            
            $columnNamesBlock.addClass('cb-field').show();
            resizeChartSeries();

          });
          
        }
        
      });
      
      tickers[$(this).attr('id')] = ticker;
    });
    
    return tickers;
    
  }
  
  function addNewAutocomplete(chart) {
    
    var inputTicker = chart.find('input[name="ticker"]').get(0);
    
    var ticker = new Awesomplete(inputTicker, {
      minChars: 1,
      maxItems: 999,
      list: [],
      sort: false,
      item: function(text, input, item_id) {
        var status = (!text.quandl_status || text.quandl_status === 'free') ? '' : 'Premium';
        var html = input.trim() === '' ? text : '<div class="awesomplete-symbol-source"><div class="awesomplete-symbol">' + text.value + '</div></div><div class="awesomplete-value-status"><div class="awesomplete-value">' + text.label + '</div><div class="awesomplete-status">' + status + '</div></div>';
        return createEl('li', {
          innerHTML: html,
          'aria-selected': 'false',
          id: 'awesomplete_list_' + this.count + '_item_' + item_id
        });
      },
      replace: function(text) {
        if (text.source === 'quandl') {
          this.input.value = text.value;
          this.input.dataset.value = text.label + '/' + text.quandl_value;
        } else {
          this.input.value = text.label;
          this.input.dataset.value = text.value;
        }
      },
      filter: function(text, input) {
        if (text.source === 'crypto') { 
          return RegExp(regExpEscape(input.trim()), 'i').test(text.label) || RegExp(regExpEscape(input.trim()), 'i').test(text.value);
        }
        return true;
      }
    });
    
    document.getElementById($(inputTicker).attr('id')).addEventListener('awesomplete-selectcomplete', function(e) {
      
      var value = e.text.value,
          source = e.text.source,
          quandl_type = e.text.quandl_type,
          $chart = $(inputTicker).closest('.cb-chart'),
          $columnNamesBlock = $chart.find('.cb-column-names'),
          $columnNames = $chart.find('select[name="column_names"]');
      
      if (source === 'quandl') {
        value = e.text.label + '/' + e.text.quandl_value;
      }
      
      $chart.find('input[name="ticker_symbol"]').val(value);
      $columnNames.find('option').remove();
      $columnNamesBlock.removeClass('cb-field').hide();
      resizeChartSeries();

      if (source === 'quandl') {
        
        $chart.find('input[name="quandl_type"]').val(quandl_type);
        
        var codes = e.text.label + '/' + e.text.quandl_value;

        var data = { 
          nonce_code: ajaxcb.nonce,
          action: 'load_quandl_column_names',
          codes: codes
        };

        $.post(ajaxcb.url, data, function(res) {

          if (+res === -1) {
            return;
          }

          var columnNames = JSON.parse(res);

          columnNames.forEach(function(column, i) {   
            var selected = (i === 0) ? ' selected' : '';
            $columnNames.append($('<option'+ selected +'></option>').attr('value', i + 1).text(column));
          });

          $columnNamesBlock.addClass('cb-field').show();
          resizeChartSeries();

        });

      }
      
    });
    
    tickers[$(inputTicker).attr('id')] = ticker;
    
  }
  
  $('body').on('keyup', 'input[name="ticker"]', function(e) {
    
    var self = this,
        $self = $(this),
        tickerType = $self.closest('.cb-chart').find('select[name="ticker_type"]').val(),
        id = $self.attr('id'),
        ticker = $self.val();
    
    if (ticker.length <= 3) return;
    
    delay(function() {
      
      var data = { 
        nonce_code: ajaxcb.nonce,
        action: 'load_autocomplete_data',
        ticker: ticker,
        tickerType: tickerType
      };

      $.post(ajaxcb.url, data, function(res) {
        
        if (+res === -1) {
          tickers[id].list = [];
          return;
        }

        var list = JSON.parse(res);

        tickers[id].list = list;

      });
      
    }, 1000);
    
    
  });
  
  // Building chart
  $('#cb-build-chart').on('click', function() {
    
    var $this = $(this),
        $spinner = $('.cb-spinner'),
        $error = $('.cb-fail'),
        $charts = $('.cb-chart'),
        $settings = $('.cb-settings'),
        errorsMsg = {
          NO_CHART: 'Add at least one chart.',
          EMPTY: 'Empty value.'
        };
    
    startSubmit($charts, $error, $this, $spinner);
    
    if (!$charts.length) {
      cancelSubmit($error, errorsMsg.NO_CHART, $this, $spinner);
      return;
    }
    
    var chartsError = addChartsErrors($charts);
    if (chartsError) {
      cancelSubmit($error, errorsMsg.EMPTY, $this, $spinner);
      return;
    }
    
    var charts = getChartsValues($charts),
        settings = getSettingsValues($settings),
        data = new FormData();
    
    if (settings.backgroundLogo.length) {
      $.each(settings.backgroundLogo, function(key, value) {
        data.append(key, value);
      });
    }
    delete settings.backgroundLogo;
    
    data.append('action', 'build_chart');
    data.append('nonce_code', ajaxcb.nonce);
    data.append('charts', JSON.stringify(charts));
    data.append('settings', JSON.stringify(settings));

    $.ajax({
      url: ajaxcb.url,
      type: 'POST',
      data: data,
      cache: false,
      dataType: 'json',
      processData: false,
      contentType: false,
      success: function(res) {
        if (res.success) {
          buildChart(res.data);
          cancelSubmit($error, '', $this, $spinner);
        } else {
          cancelSubmit($error, res.data, $this, $spinner);
        }
      }
    });
    
  });
  
  function startSubmit($charts, $error, $this, $spinner) {
    $.each($charts, function() {
      $(this).find('input[name="ticker"]').removeClass('cb-error');
      $(this).find('input[name="ticker_symbol"]').removeClass('cb-error');
    });
    $error.text('').hide();
    $this.attr('disabled', true);
    $spinner.show();
  }
  
  function cancelSubmit($error, errorMsg, $this, $spinner) {
    $error.text(errorMsg).show();
    $this.attr('disabled', false);
    $spinner.hide();
  }
  
  function addChartsErrors($charts) {
    
    var error = false;
    $.each($charts, function() {
      
      var $ticker = $(this).find('input[name="ticker"]');
      var $tickerSymbol = $(this).find('input[name="ticker_symbol"]');
      
      if (!$ticker.val()) {
        $ticker.addClass('cb-error');
        error = true;
      }
      
      if (!$tickerSymbol.val()) {
        $tickerSymbol.addClass('cb-error');
        error = true;
      }
      
    });
    
    return error;
    
  }
  
  function getChartsValues($charts) {
    
    var charts = [];
    $.each($charts, function() {
      var chart = {
        tickerType: $(this).find('select[name="ticker_type"]').val(),
        quandlType: $(this).find('input[name="quandl_type"]').val(),
        ticker: $(this).find('input[name="ticker"]').attr('data-value'),
        tickerName: $(this).find('input[name="ticker"]').val(),
        column: $(this).find('select[name="column_names"]').val() || 1,
        columnName: $(this).find('select[name="column_names"] option:selected').text(),
        axis: $(this).find('select[name="axis"]').val(),
        chartType: $(this).find('select[name="chart_type"]').val(),
        lineColor: $(this).find('input[name="line_color"]').val(),
        alpha: $(this).find('input[name="alpha"]').val(),
        lineType: $(this).find('select[name="line_type"]').val()
      };
      charts.push(chart);
    });
    
    return charts;
    
  }
  
  function getSettingsValues($settings) {
    
    var settings = {
      background: $settings.find('#background').val(),
      gridLinesColor: $settings.find('#grid-lines-color').val(),
      gridLinesColorAlpha: $settings.find('#grid-lines-color-alpha').val(),
      lineThickness: $settings.find('#line-thickness').val(),
      backgroundLogo: $settings.find('#background-logo').prop('files'),
      backgroundLogoAlpha: $settings.find('#background-logo-alpha').val(),
      displayVolume: $settings.find('#display-volume').is(':checked')
    };
    
    return settings;
    
  }
  
  var chart = null;
  var globalChartData = [];
  function buildChart(data) {
    
    globalChartData = [];
    
    $('#cb-amchart').css({ background: '#' + data.settings.background, display: 'block' });
    
    var dataSets = [],
        stockGraphsPrice = [],
        stockGraphsVolume = [],
        valueAxesPrice = [],
        valueAxesVolume = [],
        offsetLeft = 0,
        offsetRight = 0,
        marginLeft = 0,
        marginRight = 0,
        tickerTypes = [],
        chartSourcesValues = [],
        chartSourcesText = '';
    
    for (var i = 0; i < data.charts_data.length; i++) {
      
      var chartData = data.charts_data[i];
      
      tickerTypes.push(chartData.tickerType);
      
      chartData.data = JSON.parse(chartData.data);
      
      for (var j = 0; j < chartData.data.length; j++) {
        chartData.data[j].date = new Date(chartData.data[j].date * 1000);
      }
      
      globalChartData.push({
        ticker: chartData.ticker,
        tickerType: chartData.tickerType,
        columnName: chartData.columnName,
        data: chartData.data
      });
      
      var dataSet = {
        fieldMappings: [
          { fromField: 'value', toField: 'value' },
          { fromField: 'volume', toField: 'volume' }
        ],
        dataProvider: chartData.data,
        categoryField: 'date'
      };
      if (i !== 0) {
        dataSet.compared = true;
        dataSet.fieldMappings[0].toField = 'value' + i;
        dataSet.fieldMappings[1].toField = 'volume' + i;
      }
      
      var stockGraphPrice = {
        title: chartData.tickerName,
        valueField: 'value',
        valueAxis: 'ap' + (i + 1)
      };
      if (i === 0) {
        stockGraphPrice.type = chartData.chartType;
        stockGraphPrice.useDataSetColors = false;
        stockGraphPrice.lineColor = '#' + chartData.lineColor;
        stockGraphPrice.lineThickness = data.settings.lineThickness;
        stockGraphPrice.fillAlphas = chartData.alpha;
        stockGraphPrice.dashLength = chartData.lineType;
        stockGraphPrice.balloonFunction = function(graphDataItem, amGraph) {
          var title = amGraph.title;
          var value = 0;
          if (!$.isEmptyObject(graphDataItem.values)) {
            value = graphDataItem.values.value.toFixed(2);
          }
          return title + ': <b>' + value + '</b>'; 
        };
      } else {
        stockGraphPrice.valueField = 'value' + i;
        stockGraphPrice.compareField = 'value' + i;
        stockGraphPrice.comparable = true;
        stockGraphPrice.compareGraphType = chartData.chartType;
        stockGraphPrice.compareGraphLineColor = '#' + chartData.lineColor;
        stockGraphPrice.compareGraphLineThickness = data.settings.lineThickness;
        stockGraphPrice.compareGraphFillAlphas = chartData.alpha;
        stockGraphPrice.compareGraphDashLength = chartData.lineType;
        stockGraphPrice.compareGraphBalloonFunction = function(graphDataItem, amGraph) {
          var title = amGraph.title;
          var value = 0;
          if (!$.isEmptyObject(graphDataItem.values)) {
            value = graphDataItem.values.value.toFixed(2);
          }
          return title + ': <b>' + value + '</b>'; 
        };
      }
      
      var stockGraphVolume = {
        title: chartData.tickerName,
        valueField: 'volume',
        valueAxis: 'av' + (i + 1)
      };
      if (i === 0) {
        stockGraphVolume.type = chartData.chartType;
        stockGraphVolume.useDataSetColors = false;
        stockGraphVolume.lineColor = '#' + chartData.lineColor;
        stockGraphVolume.lineThickness = data.settings.lineThickness;
        stockGraphVolume.fillAlphas = chartData.alpha;
        stockGraphVolume.dashLength = chartData.lineType;
        stockGraphVolume.balloonText = '[[title]]: <b>[[value]]</b>';
      } else {
        stockGraphVolume.valueField = 'volume' + i;
        stockGraphVolume.compareField = 'volume' + i;
        stockGraphVolume.comparable = true;
        stockGraphVolume.compareGraphType = chartData.chartType;
        stockGraphVolume.compareGraphLineColor = '#' + chartData.lineColor;
        stockGraphVolume.compareGraphLineThickness = data.settings.lineThickness;
        stockGraphVolume.compareGraphFillAlphas = chartData.alpha;
        stockGraphVolume.compareGraphDashLength = chartData.lineType;
        stockGraphVolume.compareGraphBalloonText = '[[title]]: <b>[[value]]</b>';
      }
      
      var valueAxisPrice = {
        id: 'ap' + (i + 1),
        axisColor: '#' + chartData.lineColor,
        position: chartData.axis
      };
      
      var valueAxisVolume = {
        id: 'av' + (i + 1),
        axisColor: '#' + chartData.lineColor,
        position: chartData.axis
      };
      
      if (chartData.axis === 'left') {
        valueAxisPrice.offset = offsetLeft;
        valueAxisVolume.offset = offsetLeft;
        offsetLeft += 50;
        marginLeft += 50;
      } else {
        valueAxisPrice.offset = offsetRight;
        valueAxisVolume.offset = offsetRight;
        offsetRight += 50;
        marginRight += 50;
      }
      
      dataSets.push(dataSet);
      stockGraphsPrice.push(stockGraphPrice);
      valueAxesPrice.push(valueAxisPrice);
      
      if (chartData.tickerType === 'quandl') continue;
      stockGraphsVolume.push(stockGraphVolume);
      valueAxesVolume.push(valueAxisVolume);
      
    }
    
    if (tickerTypes) {
      
      chartSourcesText += 'Source: ';
      
      if (tickerTypes.indexOf('yahoo') !== -1) {
        chartSourcesValues.push('Yahoo');
      }
      
      if (tickerTypes.indexOf('crypto') !== -1) {
        chartSourcesValues.push('Cyrptocurrency');
      }
      
      if (tickerTypes.indexOf('quandl') !== -1) {
        chartSourcesValues.push('Quandl');
      }
      
      chartSourcesText += chartSourcesValues.join(', ');
      
      var monthNames = ['Jan.', 'Feb.', 'Mar.', 'Apr.', 'May', 'June',
        'July', 'Aug.', 'Sept.', 'Oct.', 'Nov.', 'Dec'
      ],
          month = monthNames[new Date().getMonth()],
          year = new Date().getFullYear();
      
      chartSourcesText += ', ' + month + ' ' + year;
      
    }
    
    var panels = [
      {
        recalculateToPercents: 'never',
        showCategoryAxis: true,
        title: 'Price',
        percentHeight: 70,
        stockGraphs: stockGraphsPrice,
        stockLegend: { markerType: 'line', valueText: '' },
        valueAxes: valueAxesPrice
      }
    ];
    
    if (data.settings.displayVolume) {
      panels.push({
        recalculateToPercents: 'never',
        showCategoryAxis: true,
        title: 'Volume',
        percentHeight: 30,
        stockGraphs: stockGraphsVolume,
        stockLegend: { valueText: '' },
        valueAxes: valueAxesVolume
      });
    }
    
    chart = AmCharts.makeChart('cb-amchart', {
      hideCredits: true,
      type: 'stock',
      categoryAxesSettings: {
        gridColor: '#' + data.settings.gridLinesColor,
        gridAlpha: data.settings.gridLinesColorAlpha
      },
      dataSets: dataSets,
      panels: panels,
      chartScrollbarSettings: {
        backgroundColor: '#ccc',
        color: '#333',
        selectedBackgroundColor: '#eee'
      },
      chartCursorSettings: {
        valueBalloonsEnabled: true,
        valueLineEnabled: true,
        valueLineBalloonEnabled: true
      },
      periodSelector: {
        inputFieldsEnabled: false,
        periodsText: '',
        position: 'top',
        periods: [
          { period: 'DD', count: 7, label: '1W' },
          { period: 'MM', selected: true, count: 1, label: '1M' },
          { period: 'MM', count: 6, label: '6M' },
          { period: 'YYYY', count: 1, label: '1Y' },
          { period: 'MAX', label: 'ALL' }
        ]
      },
      dataSetSelector: { position: '' },
      export: { 
        enabled: true,
        fabric: {
          backgroundColor: '#FFFFFF',
          removeImages: true,
          forceRemoveImages: false,
          selection: false,
          loadTimeout: 5000,
          drawing: {
            enabled: true,
            arrow: 'end',
            lineCap: 'butt',
            mode: 'pencil',
            modes: ['pencil', 'line', 'arrow'],
            color: '#000000',
            colors: ['#000000', '#FFFFFF', '#FF0000', '#00FF00', '#0000FF'],
            shapes: ['11.svg', '14.svg', '16.svg', '17.svg', '20.svg', '27.svg'],
            width: 1,
            fontSize: 16,
            widths: [1, 5, 10, 15],
            opacity: 1,
            opacities: [1, 0.8, 0.6, 0.4, 0.2],
            menu: undefined,
            autoClose: true
          },
          border: {
            fill: '',
            fillOpacity: 0,
            stroke: '#000000',
            strokeWidth: 1,
            strokeOpacity: 1
          }
        },
        exportTitles: true,
        columnNames: getExportData(globalChartData).columnNames,
        exportFields: getExportData(globalChartData).exportFields,
        processData: function(data, cfg) {
          return getExportData(globalChartData).data;
        }
      },
      valueAxesSettings: {
        gridAlpha: 0,
        axisAlpha: 1,
        inside: false
      },
      panelsSettings: { marginLeft: marginLeft, marginRight: marginRight }
    });
    
    if (data.settings.bgLogo) {
      $('.amcharts-stock-panel-div-stockPanel0').append('<img class="cb-logo-bg" src="' + ajaxcb.plugin_url + 'uploads/' + data.settings.bgLogo + '">');
      
      var $bgLogo = $('.cb-logo-bg');
      $bgLogo.css('opacity', data.settings.backgroundLogoAlpha);
      
      var marginDiff = marginLeft - marginRight;
      if (marginDiff > 0) {
        $bgLogo.css('left', 'calc(50% + ' + marginDiff / 2 + 'px)');
      } else if (marginDiff < 0) {
        
        $bgLogo.css('left', 'calc(50% - ' + Math.abs(marginDiff / 2) + 'px)');
      }
    }
    
    if (chartSourcesText) {
      $('.cb-chart-sources').text(chartSourcesText).show();
    }
    
  }
  
  // Helpers
  function regExpEscape(s) {
    return s.replace(/[-\\^$*+?.()|[\]{}]/g, '\\$&');
  }
  
  function listSort(a, b) {
    if (a.label.length !== b.label.length) {
      return a.label.length - b.label.length;
	}

	return a.label < b.label ? -1 : 1;
  }
  
  function createEl(tag, o) {
    var element = document.createElement(tag);

	for (var i in o) {
      var val = o[i];

      if (i === 'inside') {
        $(val).appendChild(element);
      } else if (i === 'around') {
        var ref = $(val);
        ref.parentNode.insertBefore(element, ref);
        element.appendChild(ref);

        if (ref.getAttribute('autofocus') != null) ref.focus();
      } else if (i in element) {
        element[i] = val;
      } else {
        element.setAttribute(i, val);
      }
	}

	return element;
  };
  
  var delay = (function() {
    var timer = 0;
    return function(callback, ms) {
      clearTimeout(timer);
      timer = setTimeout(callback, ms);
    };
  })();
  
  function getExportData(globalChartData) {
    
    var exportData = {
      exportFields: [],
      columnNames: {},
      data: []
    };
    
    if (!globalChartData.length) {
      return exportData;
    } else if (globalChartData.length === 1) {
      
      exportData.exportFields.push('date');
      exportData.columnNames['date'] = 'Date';
      
      var chart = globalChartData[0];
      var data = chart.data;
      
      if (chart.tickerType === 'quandl') {
        
        var ticker = chart.ticker;
        var columnName = chart.columnName;
        var columnNameToLowerCase = columnName.toLowerCase();
        var fieldName = ticker + ' ' + columnName;
        
        exportData.exportFields.push(columnNameToLowerCase);
        exportData.columnNames[columnNameToLowerCase] = fieldName;
        
      } else {
        
        var ticker = chart.ticker;
        var priceField = ticker + ' price';
        var volumeField = ticker + ' volume';
        
        exportData.exportFields.push('price', 'volume');
        exportData.columnNames['price'] = priceField;
        exportData.columnNames['volume'] = volumeField;
        
      }
      
      for (var i = 0; i < data.length; i++) {
        
        var exportEl = {};
        exportEl['Date'] = new Date(data[i].date).toDateString();
        
        if (chart.tickerType === 'quandl') {
          exportEl[fieldName] = data[i].value;
        } else {
          exportEl[priceField] = data[i].value;
          exportEl[volumeField] = data[i].volume;
        }
        
        exportData.data.push(exportEl);
        
      }
      
      return exportData;
      
    } else {
      
      exportData.exportFields.push('date');
      exportData.columnNames['date'] = 'Date';
      
      globalChartData.forEach(function(chart, index) {
        if (chart.tickerType === 'quandl') {
          
          var ticker = chart.ticker;
          var columnName = chart.columnName;
          var columnNameToLowerCase = columnName.toLowerCase();
          var fieldName = ticker + ' ' + columnName;

          exportData.exportFields.push(columnNameToLowerCase + index);
          exportData.columnNames[columnNameToLowerCase + index] = fieldName;
          
        } else {
          
          var ticker = chart.ticker;
          var priceField = ticker + ' price';
          var volumeField = ticker + ' volume';

          exportData.exportFields.push('price' + index, 'volume' + index);
          exportData.columnNames['price' + index] = priceField;
          exportData.columnNames['volume' + index] = volumeField;
          
        }
      });
      
      var changedChartsData = [];
      globalChartData.forEach(function(chart) {
        
        var changedData = [];
        chart.data.forEach(function(data) {
          
          var date = new Date(data.date);
          var year = date.getFullYear();
          var month = date.getMonth();
          var day = date.getDate();
          date = +new Date(year, month, day);
          
          changedData.push({
            date: date,
            value: data.value,
            volume: data.volume
          });
          
        });
        
        changedChartsData.push({
          ticker: chart.ticker,
          tickerType: chart.tickerType,
          columnName: chart.columnName,
          data: changedData
        });
        
      });
      
      var dates = [];
      changedChartsData.forEach(function(chart) {
        chart.data.forEach(function(data) {
          dates.push(data.date);
        });
      });
      dates.sort(function(a, b) {
        return a - b;
      });
      
      var uniqueDates = [];
      $.each(dates, function(index, date) {
        if($.inArray(date, uniqueDates) === -1) uniqueDates.push(date);
      });
      
      var chartsData = {};
      uniqueDates.forEach(function(date) {
        
        chartsData[date] = {};
        
        var columnNames = exportData.columnNames;
        for (var column in columnNames) {
          chartsData[date][columnNames[column]] = null;
        }
        
      });
      
      changedChartsData.forEach(function(chart) {
        
        var ticker = chart.ticker;
        
        if (chart.tickerType === 'quandl') {
          
          var columnName = chart.columnName;
          var fieldName = ticker + ' ' + columnName;

          chart.data.forEach(function(data) {
            chartsData[data.date][fieldName] = data.value;
          });
          
        } else {
          
          var priceField = ticker + ' price';
          var volumeField = ticker + ' volume';
          
          chart.data.forEach(function(data) {
            chartsData[data.date][priceField] = data.value;
            chartsData[data.date][volumeField] = data.volume;
          });
          
        }
        
      });
      
      for (var date in chartsData) {
        chartsData[date]['Date'] = new Date(+date).toDateString();
        exportData.data.push(chartsData[date]);
      }
      
      return exportData;
      
    }
    
  }
  
});