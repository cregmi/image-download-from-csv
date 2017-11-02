# image-download-from-csv
PHP script to download images by URL values, reading from given CSV file.
The PHP script assume, 'file.csv' is present in same folder with at least three column headings 'SKU', 'Description' and 'Images'
The php script enlist all the image URLs present on CSV file, from both colum headings 'Description' and 'Images', associating the URL list with the column heading 'SKU'
Directory will be created with the name 'SKU' and images for particular 'SKU' will be downloaded inside the directory.
