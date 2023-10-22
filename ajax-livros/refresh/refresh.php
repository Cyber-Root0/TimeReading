<?php

namespace Readfy\Pdf\refresh;
use Readfy\Pdf\interface\Ajax;
class Refresh implements Ajax{
    public function __construct(protected \stdClass $data){
        
    }

    public function run() : void{
        
        
        $page_id = $this->data->page_id;
        $livro_id = $this->data->livro_id;
        $path_book = $this->getPathBook($livro_id);

        $this->renderPage($path_book, $page_id);

    }

    //função para pegar o caminho do Livro com base no id
    private function getPathBook(int $idlivro){

        return __DIR__.'/../../livros/exemplo.pdf'; //retorno de exemplo
    }

    //função de renderização da pagina especifica do PDF
    private function renderPage($path, $page_id){
        try{
        $pdf = new \setasign\Fpdi\Fpdi();
        $pdf->AddPage();

        // Defina a página que você deseja abrir
        $pdf->setSourceFile($path);
        $templateId = $pdf->importPage($page_id);

        // Adicione a página ao documento atual
        $pdf->useTemplate($templateId, 10, 10);

        // Salve ou envie a saída do PDF
        $pdf->Output();
        }catch(\Exception $e){
            echo json_encode(
                [
                    "status"=> "error",
                    "msg" => $e->getMessage()
                ]
                );

        }

    }
}
