<?php


namespace app\controller;
use app\BaseController;
use PHPExcel_IOFactory;
use PHPExcel;
class MyPHPExcel extends BaseController
{
    /**
     * excel表格导出处理
     */
    public function getExport()
    {
        //1.从数据库中取出数据
//        $list = Db::name('student')->select();
        //2.实例化PHPExcel类
        $objPHPExcel = new \PHPExcel();
        //3.激活当前的sheet表
        $objPHPExcel->setActiveSheetIndex(0);
        //4.设置表格头（即excel表格的第一行）
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', '姓名')
            ->setCellValue('C1', '年龄')
            ->setCellValue('D1', '班级')
            ->setCellValue('E1', '电话')
            ->setCellValue('F1', '邮箱');
        //设置F列水平居中
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('F')->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //设置单元格宽度
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('F')->setWidth(30);
        //5.循环刚取出来的数组，将数据逐一添加到excel表格。
        for($i=0;$i<10;$i++){
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2),1);//添加ID
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2),2);//添加姓名
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2),3);//添加年龄
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2),4);//添加班级
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2),5);//添加电话
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2),6);//添加邮箱
        }
        //6.设置保存的Excel表格名称
        $filename = 'student'.date('ymd',time()).'.xls';
        //7.设置当前激活的sheet表格名称；
        $objPHPExcel->getActiveSheet()->setTitle('学生信息');
        //8.设置浏览器窗口下载表格
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$filename.'"');
        //生成excel文件
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //下载文件在浏览器窗口
        $objWriter->save('php://output');
        exit;
    }
}