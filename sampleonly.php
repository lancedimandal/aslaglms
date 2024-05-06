var CTAContent = (function( jQuery ){

var $ = jQuery;
var self = false;


$(function(){

self.ready();
try
{
}
catch( error )
{
return;
}
});


function getCheckBoxFields() {
return [
'Apac Support',
'Cyber Security',
'Audit and assurance',
'Financial Services',
'Business Advisory',
'Migration Support',
'Corporate Finance',
'Outsourced CFO',
'Corporate Recovery',
'Taxation Services',
'Wealth Management'
];
}

/* returns required functions */
return {

init : function ()
{
self = this;
},

ready : function()
{

self = this;

let cRow = $('.By_CTA_CheckerRow');

let cFields = getCheckBoxFields();

let ctr = 0;

$(cRow).each(function( r,v ){
$(this).find('.By_HP_cta_check').each(function( s,w ){
let hasmore = ctaContentData.servicesData[ctr] || false;
if ( hasmore )
{
$(this).html(`<input id="By_HP_cta_radio_${ctr}" type="checkbox" name="By_HP_cta_radio[]" class="By_HP_cta_radio"
    data-indi="${ctr}" /><label for="By_HP_cta_radio_${ctr}">${ ctaContentData.servicesData[ctr].title }</label>`);
ctr++;
}
});

});

let checkBoxStr = "input[name=By_HP_cta_radio\\[\\]]";

$(checkBoxStr).on('change',function(){

$(checkBoxStr).prop('checked',false);

$(this).prop('checked',true);

// $('.By_HP_CTA_Title .elementor-widget-container h4').html( ctaContentData.servicesData[ $(this).data('indi') ].title
);
// Sample data structure
var ctaContentData = {
servicesData: [
{
title: "Service 1",
link: "https://example.com/service1"
},
{
title: "Service 2",
link: "https://example.com/service2"
},
// Add more services with titles and links as needed
{
title: "APAC Support",
link: "https://adamd187.sg-host.com/byrons_service/apac-support/"
}
]
};

// Code to dynamically generate hyperlinks for each service
$('.By_HP_CTA_Title .elementor-widget-container').each(function(index) {
var title = ctaContentData.servicesData[index].title;
var link = ctaContentData.servicesData[index].link;

// Creating an anchor tag and setting its attributes
var anchor = $('<a>').attr('href', link).html('<h4>' + title + '</h4>');

    // Replace the content of the parent container with the anchor tag
    $(this).html(anchor);
    });
    });

    $('.By_HP_CTA_Content .elementor-widget-container').html('');
    $('.By_HP_CTA_Content .elementor-widget-container').html( ctaContentData.servicesData[ $(this).data('indi')
    ].content );

    $('.By_HP_cta_industry_list .elementor-widget-container').html( ctaContentData.servicesData[ $(this).data('indi')
    ].industries );

    let url = ( "/meet-the-team-listings-for-hp/?" + ctaContentData.servicesData[ $(this).data('indi') ].query );

    $('#By_iframe_result').attr('src',url);

    });

    $('input[data-indi=0].By_HP_cta_radio').prop('checked',true).change();


    }



    }

    })( jQuery );

    CTAContent.init();