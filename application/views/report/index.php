<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-success w-100" id="btn-purchase">Generate Report Purchase</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success w-100" id="btn-sale">Generate Report Sale</button>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- EXCEL -->
<script src="<?=base_url('assets/json-to-excel/js/xlsx.core.min.js') ?>"></script>
<script src="<?=base_url('assets/json-to-excel/js/FileSaver.js') ?>"></script>
<script src="<?=base_url('assets/json-to-excel/js/jhxlsx.js') ?>"></script>
<!-- PDF -->
<script src="<?=base_url('assets/jspdf/dist/jspdf.umd.min.js') ?>"></script>
<script src="<?=base_url('assets/jspdf/autotable.js') ?>"></script>

<script>
$(document).on('click', '#btn-purchase', function() {
    process('Generate Report Purchase ?', `${base_url}report/purchase`, 'Report Transaction Purchase')
})

$(document).on('click', '#btn-sale', function() {
    process('Generate Report Sale ?', `${base_url}report/sale`, 'Report Transaction Sale')
})

function process(title, url, fileTitle) {
    swallConfirm({
        title: title,
        url: url,
        data: new FormData(),
    })
    .then((result) => {
        console.log('result',result)
        if (result.isConfirmed) {
            if (!result.value.status) {
                swal.fire('Opss...!', result.value.message, 'warning')
            }
            if (result.value.status) {
                swal.fire('Good job !', result.value.message, 'success')
                generateExcel(result.value.data, fileTitle)
                generatePdf(result.value.data, fileTitle)
            }
        }
    })
}

async function generateExcel(res, title) {
    let jsonData = [[
        {'text':'No'},
        {'text':'Product Name'},
        {'text':'Product Price'},
        {'text':'Transaction Qty'},
        {'text':'Total'},
        {'text':'Invoice'},
        {'text':'Supplier'}
    ]]

    await res.map((val, index) => {
        jsonData.push([
            {'text': index+1},
            {'text': val.product_name},
            {'text': INA(val.price)},
            {'text': val.qty},
            {'text': INA(val.sub_total)},
            {'text': val.invoice},
            {'text': val.supplier_name}
        ])
    })

    await Jhxlsx.export(
        [{
            "sheetName": "Sheet1",
            "data": jsonData
        }], 
        {fileName: title}
    )
}

async function generatePdf(res, title) {
    window.jsPDF = window.jspdf.jsPDF

    var doc = new jsPDF({
        orientation: 'P',
        unit: 'mm',
        format: 'a4',
        putOnlyUsedFonts:true,
    })

    var col = ['No','Product Name','Product Price','Transaction Qty','Total','Invoice','Supplier']
    var rows = []

    await res.map((val, index) => {
        rows.push([
            index+1,
            val.product_name,
            INA(val.price),
            val.qty,
            INA(val.sub_total),
            val.invoice,
            val.supplier_name,
        ])
    })

    doc.autoTable({
        styles: { fontSize: 6 },
        head: [col],
        body: rows,
        didDrawPage: async function (data) {
            // Header
            doc.setFontSize(18)
            doc.setTextColor(40)
            doc.text(title, data.settings.margin.left + 45, 22)
            if (base64Img) {
                await doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 40, 10)
            }
        },
        margin: { top: 30 },
    })
    doc.save(title+'.pdf')
}

function imgToBase64(src, callback) {
    var outputFormat = src.substr(-3) === 'png' ? 'image/png' : 'image/jpeg'
    var img = new Image()
    img.crossOrigin = 'Anonymous'
    img.onload = function() {
        var canvas = document.createElement('CANVAS')
        var ctx = canvas.getContext('2d')
        var dataURL
        canvas.height = this.naturalHeight
        canvas.width = this.naturalWidth
        ctx.drawImage(this, 0, 0)
        dataURL = canvas.toDataURL(outputFormat)
        callback(dataURL)
    }
    img.src = src
    if (img.complete || img.complete === undefined) {
        img.src = "data:image/gifbase64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
        img.src = src
    }
}

let base64Img
imgToBase64('https://majoo.id/assets/img/main-logo.png', function(base64) {
    base64Img = base64
})

function INA(number) {
    return new Intl.NumberFormat(['ban', 'id']).format(number)
}
</script>
<?php $this->load->view('template/footer') ?>