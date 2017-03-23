var pc_paging = function(offset = 0) {

    //remove table data
    var $table_block = $(".prd_table");
    var $title_line = $(".table_title");
    var $tr_lines = $(".prd_table tr");
    $tr_lines.remove();
    $title_line.appendTo($table_block);

    //remove paging number
    var $paging_block = $(".pagination");
    var $page_lines = $(".pagination li");
    $page_lines.remove();

    $.ajax({
        url: "/product_ajax.php?offset=" + offset,
        dataType: 'json',
        success: function(data) {
            var $tabletag = $('.prd_table');
            var sortable = data.results;


            //descending order by id
            sortable.sort(function(a, b) {
                return b.id - a.id;
            })

            //write data table
            for (var index in sortable) {
                var $tr_tag = $('<tr class="pr_line"' + index + '></div>');
                for (var field_name in sortable[index]) {
                    var $td_tag = $("<td class=" + field_name + ">" + sortable[index][field_name] + "</td>");
                    $td_tag.appendTo($tr_tag)
                }
                $tr_tag.appendTo($tabletag);
            }

            //write pagination
            var $paging_block = $(".pagination");
            var $bf_arrow = $("<li><<<</li>");

            var $af_arrow = $("<li>>>></li>");
            console.log(data);
            if (data['url_pre1']) {
                $bf_arrow = $("<li><a href='#' class='paging' data-offset=" + data['url_pre1'] + "><<<</li>");
            }
            if (data['url_next1']) {
                $af_arrow = $("<li><a href='#' class='paging' hdata-offset=" + data['url_next1'] + ">>>></a></li>");
            }
            $bf_arrow.appendTo($paging_block);
            var now_num = data.page_num.now_num;
            for (var key in data.page_num) {
                var $page_num = $('<li></li>');
                var $a_link = $("<a class='paging'></a>");
                if (data.page_num[key] == "now_num") {
                    $a_link = $("<a class='paging' href='#' data-offset=" + data.page_num[key] + ">" + key + "</a>");

                } else {
                    $a_link = $("<a class='paging' href='#' data-offset=" + data.page_num[key] + ">" + key + "</a>");
                }
                $a_link.appendTo($page_num)
                $page_num.appendTo($paging_block);
            }
            $af_arrow.appendTo($paging_block);
            $('a.paging').click(function() {
                var data_offset = $(this).data('offset');
                pc_paging(data_offset);
            });
        }
    });
};


var mobli_paging = function(offset=0) {
	
    //remove paging
    var $paging_block = $(".pagination");
    var $page_lines = $(".pagination li");
    $page_lines.remove();

    $.ajax({
        url: "/product_ajax.php?offset=" + offset,
        dataType: 'json',
        success: function(data) {
            var $tabletag = $('.prd_table');
            var sortable = data.results;


            //descending order by id
            sortable.sort(function(a, b) {
                return b.id - a.id;
            })

            //write data table
            for (var index in sortable) {
                var $tr_tag = $('<tr class="pr_line"' + index + '></div>');
                for (var field_name in sortable[index]) {
                    var $td_tag = $("<td class=" + field_name + ">" + sortable[index][field_name] + "</td>");
                    $td_tag.appendTo($tr_tag)
                }
                $tr_tag.appendTo($tabletag);
            }

            //write pagination
            var $paging_block = $(".pagination");
            var $get_more = $("<li><a class='paging' data-offset="+data['url_next1']+">다음 페이지 더 보기</li>");
            $get_more.appendTo($paging_block);

            $('a.paging').click(function() {
                var data_offset = $(this).data('offset');
                mobli_paging(data_offset);
            });
        }
    });
};
