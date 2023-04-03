<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;

    //setup
    public function setUp(): void
    {
        parent::setUp();
        //acting as superadmin
        $this->actingAs(User::find(1));
    }

    //test superadmin can see mahasiswa index
    public function test_superadmin_can_see_mahasiswa_index()
    {
        //open mahasiswa index
        $response = $this->get(route('mahasiswa.index'));
        //assert status 200
        $response->assertStatus(200);
        //assert view has mahasiswa list
        $response->assertViewHas('mahasiswa', Mahasiswa::paginate(5));
    }

    /** @test */
    public function test_superadmin_can_see_mahasiswa_index_page_2()
    {
        //open mahaiswa index page 2
        $response = $this->get(route('mahasiswa.index', ['page' => 2]));
        //assert status 200
        $response->assertStatus(200);
        //assert view has mahasiswa list
        $response->assertViewHas('mahasiswa', Mahasiswa::paginate(5));
    }

    /** @test */
    public function test_superadmin_can_open_create_mahasiswa()
    {
        // open create mahasiswa page
        $response = $this->get(route('mahasiswa.create'));
        //assert can see text tambah mahasiswa
        $response->assertSeeText('Tambah Mahasiswa');
        //assert status 200
        $response->assertStatus(200);
    }
    /** @test */
    public function test_superadmin_can_create_mahasiswa()
    {
        //open create mahasiswa page
        $response = $this->get(route('mahasiswa.create'));
        //assert status 200
        $response->assertStatus(200);
        //create mahasiswa
        $response = $this->post(route('mahasiswa.store'), [
            'nama' => 'Putra Prima',
            'nim' => '0410630078',
            'email' => 'putraprima@gmail.com',
            'jurusan' => 'informatik',
            'nomor_handphone' => '0812318723',
            'alamat' => 'MAlang',
        ]);
        //assert redirect to mahasiswa index
        $response->assertRedirect(route('mahasiswa.index'));
        //assert mahasiswa created
        $this->assertDatabaseHas('mahasiswa', [
            'nama' => 'Putra Prima',
            'nim' => '0410630078',
            'email' => 'putraprima@gmail.com',
            'jurusan' => 'informatik',
            'nomor_handphone' => '0812318723',
            'alamat' => 'MAlang',
        ]);
    }

    /** @test */
    public function test_superadmin_can_not_create_mahasiswa_nim_unique()
    {
        // Open create mahasiswa page
        $response = $this->get(route('mahasiswa.create'));
        //assert status 200
        $response->assertStatus(200);
        //create one mahsiswa using factory
        $mahasiswa = Mahasiswa::factory()->create();
        //create another mahasiswa with same nim
        $response = $this->post(route('mahasiswa.store'), [
            'nama' => 'Putra Prima',
            'nim' => $mahasiswa->nim,
            'email' => 'putraprima@gmail.com',
            'jurusan' => 'informatik',
            'nomor_handphone' => '0812318723',
            'alamat' => 'MAlang',
        ]);

        //assert validation error nim already exist
        $response->assertSessionHasErrors('nim');
    }
    /** @test */
    public function test_superadmin_can_not_create_mahasiswa_email_unique()
    {
        //open create mahasiswa page
        $response = $this->get(route('mahasiswa.create'));
        //assert status 200
        $response->assertStatus(200);
        //create one mahasiswa using factory
        $mahasiswa = Mahasiswa::factory()->create();
        //create another mahasiswa with same email
        $response = $this->post(route('mahasiswa.store'), [
            'nama' => 'Putra Prima',
            'nim' => '0410630078',
            'email' => $mahasiswa->email,
            'jurusan' => 'informatik',
            'nomor_handphone' => '0812318723',
            'alamat' => 'MAlang',
        ]);
        //assert validation error email already exist
        $response->assertSessionHasErrors('email');
    }

    /** @test
     * @dataProvider mahasiswaValidationProvider
     */
    public function test_validation_for_superadmin_create_mahasiswa($invalidInput, $invalidField)
    {
        // Test
        $this->post(route('mahasiswa.store'), $invalidInput)
            ->assertSessionHasErrors($invalidField)
            ->assertStatus(302);
    }
    public function mahasiswaValidationProvider()
    {
        return [
            'nama required' => [
                [
                    'nama' => '',
                    'nim' => '1234567890',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nama']
            ],
            'nim minimal 10 digits' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '123456789',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'nim required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'nim numeric' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => 'abc',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'nim already used' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567891',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'email required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => '',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['email']
            ],
            'email valid' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['email']
            ],
            'email already used' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567891',
                    'email' => 'rizky@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['email']
            ],
            'jurusan required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => '',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['jurusan']
            ],
            'nomor hp required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'informatika',
                    'nomor_handphone' => '',
                    'alamat' => 'Malang',
                ],
                ['nomor_handphone']
            ],
            'nomor hp minimal 10 digit' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'informatika',
                    'nomor_handphone' => '12345',
                    'alamat' => 'Malang',
                ],
                ['nomor_handphone']
            ],
            'alamat required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'informatika',
                    'nomor_handphone' => '12345',
                    'alamat' => '',
                ],
                ['nomor_handphone']
            ],
        ];
    }

    //create test for superadmin can delete mahasiswa
    /** @test */
    public function test_superadmin_can_delete_mahasiswa()
    {
        //create one mahasiswa using factory
        $mahasiswa = Mahasiswa::factory()->create();
        //delete mahasiswa
        $response = $this->delete(route('mahasiswa.destroy', $mahasiswa->id));
        //assert status 302
        $response->assertStatus(302);
        //assert redirect to mahasiswa index with message
        $response->assertSessionHas('success', 'Mahasiswa berhasil dihapus');
        //assert redirect to mahasiswa index
        $response->assertRedirect(route('mahasiswa.index'));
        //assert mahasiswa not found in database
        $this->assertDatabaseMissing('mahasiswa', [
            'id' => $mahasiswa->id,
        ]);
    }

    //create test for superadmin can update mahasiswa
    /** @test */
    public function test_superadmin_can_update_mahasiswa()
    {
        //create one mahasiswa using factory
        $mahasiswa = Mahasiswa::factory()->create();
        //edit mahasiswa
        $response = $this->put(route('mahasiswa.update', $mahasiswa->id), [
            'nama' => 'Putra Prima',
            'nim' => '0410630078',
            'email' => 'putraprima@gmail.com',
            'jurusan' => 'Informatika',
            'nomor_handphone' => '1234567890',
            'alamat' => 'Malang',
        ]);
        //assert status 302
        $response->assertStatus(302);
        //assert redirect to mahasiswa index with message
        $response->assertSessionHas('success', 'Mahasiswa berhasil diupdate');
        //assert redirect to mahasiswa index
        $response->assertRedirect(route('mahasiswa.index'));
        //assert mahasiswa found in database
        $this->assertDatabaseHas('mahasiswa', [
            'id' => $mahasiswa->id,
            'nama' => 'Putra Prima',
            'nim' => '0410630078',
            'email' => 'putraprima@gmail.com',
            'jurusan' => 'Informatika',
            'nomor_handphone' => '1234567890',
            'alamat' => 'Malang',
        ]);
    }

    //create test for superadmin can open edit page
    /** @test */
    public function test_superadmin_can_open_edit_page()
    {
        //create one mahasiswa using factory
        $mahasiswa = Mahasiswa::factory()->create();
        //open edit page
        $response = $this->get(route('mahasiswa.edit', $mahasiswa->id));
        //assert status 200
        $response->assertStatus(200);
        //assert view is mahasiswa.edit
        $response->assertViewIs('mahasiswa.edit');
        //assert view has mahasiswa
        $response->assertViewHas('mahasiswa');
    }

    /** @test
     * @dataProvider mahasiswaUpdateValidationProvider
     */
    public function test_validation_for_superadmin_update_mahasiswa($invalidInput, $invalidField)
    {
        //create one mahasiswa using factory
        $mahasiswa = Mahasiswa::factory()->create();
        // Test
        $this->put(route('mahasiswa.update', $mahasiswa), $invalidInput)
            ->assertSessionHasErrors($invalidField)
            ->assertStatus(302);
    }
    public function mahasiswaUpdateValidationProvider()
    {
        return [
            'nama required' => [
                [
                    'nama' => '',
                    'nim' => '1234567890',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nama']
            ],
            'nim minimal 10 digits' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '123456789',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'nim required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'nim numeric' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => 'abc',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'nim already used' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567891',
                    'email' => 'putraprima@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['nim']
            ],
            'email required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => '',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['email']
            ],
            'email valid' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['email']
            ],
            'email already used' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567891',
                    'email' => 'rizky@gmail.com',
                    'jurusan' => 'Informatika',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['email']
            ],
            'jurusan required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => '',
                    'nomor_handphone' => '081381111111',
                    'alamat' => 'Malang',
                ],
                ['jurusan']
            ],
            'nomor hp required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'informatika',
                    'nomor_handphone' => '',
                    'alamat' => 'Malang',
                ],
                ['nomor_handphone']
            ],
            'nomor hp minimal 10 digit' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'informatika',
                    'nomor_handphone' => '12345',
                    'alamat' => 'Malang',
                ],
                ['nomor_handphone']
            ],
            'alamat required' => [
                [
                    'nama' => 'Putra Prima',
                    'nim' => '1234567890',
                    'email' => 'putraprimacom',
                    'jurusan' => 'informatika',
                    'nomor_handphone' => '12345',
                    'alamat' => '',
                ],
                ['nomor_handphone']
            ],
        ];
    }
}
