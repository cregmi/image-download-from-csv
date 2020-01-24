# image-download-from-csv
- PHP script to download images by URL values. The image urls are read from given CSV file.
- The PHP script assumes that the 'file.csv' is present in same folder with at least three column headings 'ID', 'Image-url' and 'Image-tag'.
- The php script reads the CSV file and enlist all the image URLs found in the colums 'Image-url' and 'Image-tag'. If multiple urls are given in the 'Image-url' column, they should be separated by comma. The content in the 'Image-tag' is expected to be HTML document / snippet which can contain multiple <img>...</img> tags.    
- Folders are created with the name 'ID' and images for that particular 'ID' will be downloaded inside that folder.
- The example file.csv has two rows, thus two folders are created by the php script with name 186 and 187 which are the IDs of rows.
- In the file.csv, for the first row 6 image urls are given (2 as Image-url and 4 as Image-tag) and for the second row 3 image urls are given. Thus the php script downloads 9 images altogether, 6 within the folder 186 and 3 within the folder 187.

![Output](https://github.com/cregmi/image-download-from-csv/blob/master/output.png)
