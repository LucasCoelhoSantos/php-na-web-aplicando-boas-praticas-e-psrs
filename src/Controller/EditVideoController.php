<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $requestBody = $request->getParsedBody();
        $id = filter_var($requestBody["id"], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            return new Response(302, ["Locarion" => "/"]);
            header("Location: /?sucesso=0");
        }

        $url = filter_var($requestBody["url"], FILTER_VALIDATE_URL);
        if ($url === false) {
            return new Response(302, ["Locarion" => "/"]);
            header("Location: /?sucesso=0");
        }
        $titulo = filter_var($requestBody["titulo"]);
        if ($titulo === false) {
            return new Response(302, ["Locarion" => "/"]);
            header("Location: /?sucesso=0");
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        $files = $request->getUploadedFiles();
        $uploadedImage = $files["image"];
        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata("uri");
            $mimeType = $finfo->file($tmpFile);

            if (str_starts_with($mimeType, "image/")) {
                $safeFileName = uniqid("upload_") . "_" . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . "/../../public/img/uploads/" . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->update($video);

        if ($success === false) {
            $this->addErrorMessage("Erro ao cadastrar vídeo");
            return new Response(302, ["Location" => "/novo-video"]);
        }

        return new Response(302, ["Location" => "/"]);
    }
}