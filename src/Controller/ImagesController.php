<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Images Controller
 *
 * @property \App\Model\Table\ImagesTable $Images
 */
class ImagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Messages']
        ];
        $images = $this->paginate($this->Images);

        $this->set(compact('images'));
        $this->set('_serialize', ['images']);
    }

    /**
     * View method
     *
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $image = $this->Images->get($id, [
            'contain' => ['Messages']
        ]);

        $this->set('image', $image);
        $this->set('_serialize', ['image']);
    }

	public function show($id, $thumb = 0){
		$this->autoRender = FALSE;
		$image = $this->Images->get($id);

		if ($image != NULL) {
	//		var_dump($image);

			header('Content-type: ' . h($image->type));
			if ($thumb == 0) {
				echo stream_get_contents($image->data);
			} else {
				echo stream_get_contents($image->thumb);
			}
			exit();
		}
	}

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		//var_dump($this->request->data);
        $image = $this->Images->newEntity();
        if ($this->request->is('ajax') || true) {
			$data = $this->request->data;
			if(!key_exists('image', $data)) {
				echo 'Image data not found.';
				exit();
			}
			$file = $data['image'];
			$this->autoRender = FALSE;

            $image = $this->Images->patchEntity($image, $this->request->data);

			$tmp_name = $file["tmp_name"];

			if (! is_uploaded_file($tmp_name)) {
				echo 'ng';
				exit();
			}

            $original_image = $this->imagecreatefromfile($tmp_name);
            $rotate_flg = false;

            // 向き修正
            $exif_datas = @exif_read_data($tmp_name);
            if (isset($exif_datas['Orientation'])) {
                $orientation = $exif_datas['Orientation'];
                if($orientation == 6) { // 時計回りに90
                    $original_image = imagerotate($original_image, 270, 0, 0);
                    $rotate_flg = true;
                } else if ($orientation == 8) { // 反時計回りに90
                    $original_image = imagerotate($original_image, 90, 0, 0);
                    $rotate_flg = true;
                }

                if ($rotate_flg) {
                    ImageJpeg($original_image, $tmp_name);
                }
                $this->log('orientation:'.$orientation, 'debug');
            } else {
                $this->log('orientation: none', 'debug');
                $this->log(print_r($exif_datas, true), 'debug');
            }

			// Create thumbnail
			$new_width = 200;
            /*if ($rotate_flg) {
                list($image_h, $image_w) = getimagesize($tmp_name);
            } else {*/
                list($image_w, $image_h) = getimagesize($tmp_name);
            //}

			$proportion = $image_w / $image_h;
			$new_height = $new_width / $proportion;

			if($proportion < 1){
				$new_height = $new_width;
				$new_width = $new_width * $proportion;
			}

			$canvas = imagecreatetruecolor($new_width, $new_height);

			imagecopyresampled($canvas,  // 背景画像
				 $original_image,   // コピー元画像
				 0,        // 背景画像の x 座標
				 0,       // 背景画像の y 座標
				 0,        // コピー元の x 座標
				 0,        // コピー元の y 座標
				 $new_width,   // 背景画像の幅
				 $new_height,  // 背景画像の高さ
				 $image_w, // コピー元画像ファイルの幅
				 $image_h  // コピー元画像ファイルの高さ
			);
			ob_start();
			imagejpeg($canvas,           // 背景画像
				null,    // 出力するファイル名（省略すると画面に表示する）
				100                // 画像精度（この例だと100%で作成）
			);

			$image->thumb = ob_get_clean();

			$image->data = file_get_contents($tmp_name);
			$image->type = $file["type"];

            if ($this->Images->save($image)) {
                echo $image->id;
            } else {
                echo 'ng';
            }
        }
        $messages = $this->Images->Messages->find('list', ['limit' => 200]);
        $this->set(compact('image', 'messages'));
        $this->set('_serialize', ['image']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $image = $this->Images->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $image = $this->Images->patchEntity($image, $this->request->data);
            if ($this->Images->save($image)) {
                $this->Flash->success(__('The image has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The image could not be saved. Please, try again.'));
            }
        }
        $messages = $this->Images->Messages->find('list', ['limit' => 200]);
        $this->set(compact('image', 'messages'));
        $this->set('_serialize', ['image']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Image id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $image = $this->Images->get($id);
        if ($this->Images->delete($image)) {
            $this->Flash->success(__('The image has been deleted.'));
        } else {
            $this->Flash->error(__('The image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


	private function imagecreatefromfile($path, $user_functions = false)
	{
		$info = @getimagesize($path);

		if(!$info)
		{
			return false;
		}

		$functions = array(
			IMAGETYPE_GIF => 'imagecreatefromgif',
			IMAGETYPE_JPEG => 'imagecreatefromjpeg',
			IMAGETYPE_PNG => 'imagecreatefrompng',
			IMAGETYPE_WBMP => 'imagecreatefromwbmp',
			IMAGETYPE_XBM => 'imagecreatefromwxbm',
			);

		if($user_functions)
		{
			$functions[IMAGETYPE_BMP] = 'imagecreatefrombmp';
		}

		if(!$functions[$info[2]])
		{
			return false;
		}

		if(!function_exists($functions[$info[2]]))
		{
			return false;
		}

		return $functions[$info[2]]($path);
	}
}
