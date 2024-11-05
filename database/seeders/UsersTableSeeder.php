<?php

namespace Database\Seeders;

use App\Models\StudentProfile;
use App\Models\User;
use App\Models\StudentTeacherRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('ja_JP');

        // 講師・生徒情報登録
        User::insert([
            [
                'id' => 1,
                'family_name' => '管理', 'first_name' => '洋一', 'family_name_kana' => 'かんり', 'first_name_kana' => 'よういち',
                'nickname' => null,
                'icon' => 'K1GnSWcob1NwBQ9q2C0ukwRd76u6j6hdxl5cYbxm.png',
                'tel' => '03-1234-5678',
                'email' => 'admin@test.com',
                'line_id' => null,
                'role' => 'admin',
                'active' => 1,
                'school_id' => 1,
                'password' => '$2y$10$KbcRpSLWQPdbUlcBu1fcCeqqegMBywyQZtI62INLywoxhx0sGyEUm',
                'register_student_token' => 'NXTdXSWsllJcJi2nfSC13CrbeCQKjCcR',
                'email_verified_at' => '2023-04-09 00:43:23',
                'created_at' => '2023-03-26 16:14:34',
                'updated_at' => '2023-04-01 07:40:41',
            ],
            [
                'id' => 2,
                'family_name' => '講師', 'first_name' => '花子', 'family_name_kana' => 'こうし', 'first_name_kana' => 'はなこ',
                'nickname' => null,
                'icon' => null,
                'tel' => '080-1122-3344',
                'email' => 'teacher@test.com',
                'line_id' => null,
                'role' => 'teacher',
                'active' => 1,
                'school_id' => 1,
                'password' => '$2y$10$KbcRpSLWQPdbUlcBu1fcCeqqegMBywyQZtI62INLywoxhx0sGyEUm',
                'register_student_token' => 'SpbXcnrIAOQferLaUuzLE5VIeJ4pIZqF',
                'email_verified_at' => '2023-04-09 00:43:23',
                'created_at' => '2023-03-29 00:50:43',
                'updated_at' => '2023-03-29 00:50:43',
            ],
            [
                'id' => 3,
                'family_name' => '生徒', 'first_name' => '太郎', 'family_name_kana' => 'せいと', 'first_name_kana' => 'たろう',
                'nickname' => null,
                'icon' => null,
                'tel' => '070-4455-6677',
                'email' => 'student@test.com',
                'line_id' => null,
                'role' => 'student',
                'active' => 1,
                'school_id' => 1,
                'password' => '$2y$10$KbcRpSLWQPdbUlcBu1fcCeqqegMBywyQZtI62INLywoxhx0sGyEUm',
                'register_student_token' => 'zyx',
                'email_verified_at' => '2023-04-09 00:43:23',
                'created_at' => '2023-03-29 01:22:49',
                'updated_at' => '2023-03-29 01:22:49',
            ],
            [
                'id' => 4,
                'family_name' => '管理', 'first_name' => '二郎', 'family_name_kana' => 'かんり', 'first_name_kana' => 'じろう',
                'nickname' => null,
                'icon' => '9abYjB45AFKtU5JD7u6PZksC6WQwqE6QcTfbDGKt.jpg',
                'tel' => '090-2233-4455',
                'email' => 'admin2@test.com',
                'line_id' => null,
                'role' => 'admin',
                'active' => 1,
                'school_id' => 1,
                'password' => '$2y$10$KbcRpSLWQPdbUlcBu1fcCeqqegMBywyQZtI62INLywoxhx0sGyEUm',
                'register_student_token' => 'P8stXaDdlTu2hSqOexYGKd2N3fnLJYdj',
                'email_verified_at' => '2023-04-09 00:43:23',
                'created_at' => '2023-04-01 08:04:59',
                'updated_at' => '2023-04-01 08:04:37',
            ],
            [
                'id' => 5,
                'family_name' => '管理', 'first_name' => '三郎', 'family_name_kana' => 'かんり', 'first_name_kana' => 'さぶろう',
                'nickname' => null,
                'icon' => '75qpEj4iKuQXrxA0id92SU282vZPzzouOrw6KGlc.png',
                'tel' => '090-3344-5566',
                'email' => 'admin3@test.com',
                'line_id' => null,
                'role' => 'admin',
                'active' => 1,
                'school_id' => 2,
                'password' => '$2y$10$KbcRpSLWQPdbUlcBu1fcCeqqegMBywyQZtI62INLywoxhx0sGyEUm',
                'register_student_token' => null,
                'email_verified_at' => '2023-04-09 00:43:23',
                'created_at' => '2023-04-02 15:20:08',
                'updated_at' => '2023-04-02 18:20:22',
            ],
        ]);
        StudentProfile::create(
            [
                'user_id' => 3,
                'lesson_plan_id' => 1,
                'memo' => $faker->realText(50),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        $names = $this->getNameList();
        for ($i = 0; $i < count($names); $i++) {
            $areaCode = ['070', '080', '090'];
            $phoneNumber = $faker->unique()->numerify('####-####');
            $mobileNumber = $faker->randomElement($areaCode) . '-' . $phoneNumber;

            $data = [
                'family_name' => $names[$i]['family_name'],
                'first_name' => $names[$i]['first_name'],
                'family_name_kana' => $names[$i]['family_name_kana'],
                'first_name_kana' => $names[$i]['first_name_kana'],
                'icon' => null,
                'tel' => $mobileNumber,
                'email' => $faker->unique()->safeEmail,
                'line_id' => Str::random(10),
                'role' => $faker->randomElement(['teacher', 'student']),
                'active' => $faker->randomElement([0, 1]),
                'school_id' => $faker->numberBetween(1, 5),
                'password' => '$2y$10$KbcRpSLWQPdbUlcBu1fcCeqqegMBywyQZtI62INLywoxhx0sGyEUm',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $data['register_student_token'] = (in_array($data['role'], ['admin', 'teacher'])) ? Str::random(10) : null;
            $data['nickname'] = ($data['role'] == 'student') ? $faker->unique()->userName : null;
            $user = User::create($data);

            // 生徒の場合は生徒情報追加
            if ($data['role'] == 'student'){
                StudentProfile::create(
                    [
                        'user_id' => $user->id,
                        'lesson_plan_id' => $faker->numberBetween(1, 3),
                        'memo' => $faker->realText(50),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }

        // 講師と生徒のユーザーデータを取得
        $teachers = User::where('role', 'teacher')
            ->orWhere('role', 'admin')
            ->get();
        $students = User::where('role', 'student')->get();

        // 担当講師の設定
        foreach ($students as $student) {
            if ($student->id == 3) {
                StudentTeacherRelation::create(
                    [
                        'student_id' => 3,
                        'teacher_id' => 1,
                        'category'   => 'main'
                    ],
                    [
                        'student_id' => 3,
                        'teacher_id' => 2,
                        'category'   => 'sub'
                    ]
                );
                continue;
            }

            $teacher = $teachers->where('school_id', $student->school_id)->random();
            StudentTeacherRelation::create([
                'student_id' => $student->id,
                'teacher_id' => $teacher->id,
                'category'   => 'main'
            ]);

            $teacher_sub = $teachers->where('school_id', $student->school_id)->random();
            while ($teacher_sub->id == $teacher->id) {
                $teacher_sub = $teachers->where('school_id', $student->school_id)->random();
            }
            StudentTeacherRelation::create([
                'student_id' => $student->id,
                'teacher_id' => $teacher_sub->id,
                'category'   => 'sub'
            ]);
        }
    }

    public function getNameList()
    {
        return [
            ['family_name' => '藤原', 'first_name' => '優香', 'family_name_kana' => 'ふじわら', 'first_name_kana' => 'ゆうか'],
            ['family_name' => '松本', 'first_name' => '悠真', 'family_name_kana' => 'まつもと', 'first_name_kana' => 'ゆうま'],
            ['family_name' => '宮田', 'first_name' => '舞子', 'family_name_kana' => 'みやた', 'first_name_kana' => 'まいこ'],
            ['family_name' => '原田', 'first_name' => '諒介', 'family_name_kana' => 'はらだ', 'first_name_kana' => 'りょうすけ'],
            ['family_name' => '福田', 'first_name' => '彩夏', 'family_name_kana' => 'ふくだ', 'first_name_kana' => 'あやか'],
            ['family_name' => '川島', 'first_name' => '正人', 'family_name_kana' => 'かわしま', 'first_name_kana' => 'まさと'],
            ['family_name' => '伊藤', 'first_name' => '美沙子', 'family_name_kana' => 'いとう', 'first_name_kana' => 'みさこ'],
            ['family_name' => '大塚', 'first_name' => '隆史', 'family_name_kana' => 'おおつか', 'first_name_kana' => 'たかふみ'],
            ['family_name' => '西山', 'first_name' => '茜', 'family_name_kana' => 'にしやま', 'first_name_kana' => 'あかね'],
            ['family_name' => '田口', 'first_name' => '理央', 'family_name_kana' => 'たぐち', 'first_name_kana' => 'りおう'],
            ['family_name' => '山口', 'first_name' => '将人', 'family_name_kana' => 'やまぐち', 'first_name_kana' => 'まさと'],
            ['family_name' => '小松', 'first_name' => '祐介', 'family_name_kana' => 'こまつ', 'first_name_kana' => 'ゆうすけ'],
            ['family_name' => '島田', 'first_name' => '里奈', 'family_name_kana' => 'しまだ', 'first_name_kana' => 'りな'],
            ['family_name' => '西川', 'first_name' => '大輔', 'family_name_kana' => 'にしかわ', 'first_name_kana' => 'だいすけ'],
            ['family_name' => '石井', 'first_name' => '亜美', 'family_name_kana' => 'いしい', 'first_name_kana' => 'あみ'],
            ['family_name' => '堀田', 'first_name' => '光平', 'family_name_kana' => 'ほった', 'first_name_kana' => 'こうへい'],
            ['family_name' => '伊東', 'first_name' => '桃子', 'family_name_kana' => 'いとう', 'first_name_kana' => 'ももこ'],
            ['family_name' => '佐野', 'first_name' => '涼介', 'family_name_kana' => 'さの', 'first_name_kana' => 'りょうすけ'],
            ['family_name' => '宮崎', 'first_name' => '麻衣', 'family_name_kana' => 'みやざき', 'first_name_kana' => 'まい'],
            ['family_name' => '川端', 'first_name' => '慎太郎', 'family_name_kana' => 'かわばた', 'first_name_kana' => 'しんたろう'],
            ['family_name' => '横山', 'first_name' => '大和', 'family_name_kana' => 'よこやま', 'first_name_kana' => 'ひろと'],
            ['family_name' => '吉田', 'first_name' => 'みさと', 'family_name_kana' => 'よしだ', 'first_name_kana' => 'みさと'],
            ['family_name' => '松岡', 'first_name' => '雄太', 'family_name_kana' => 'まつおか', 'first_name_kana' => 'ゆうた'],
            ['family_name' => '田辺', 'first_name' => '絵美', 'family_name_kana' => 'たなべ', 'first_name_kana' => 'えみ'],
            ['family_name' => '岩田', 'first_name' => '宏太', 'family_name_kana' => 'いわた', 'first_name_kana' => 'こうた'],
            ['family_name' => '小泉', 'first_name' => '真琴', 'family_name_kana' => 'こいずみ', 'first_name_kana' => 'まこと'],
            ['family_name' => '松田', 'first_name' => '陸', 'family_name_kana' => 'まつだ', 'first_name_kana' => 'りく'],
            ['family_name' => '野村', 'first_name' => '奈々', 'family_name_kana' => 'のむら', 'first_name_kana' => 'なな'],
            ['family_name' => '大島', 'first_name' => '真希', 'family_name_kana' => 'おおしま', 'first_name_kana' => 'まき'],
            ['family_name' => '中原', 'first_name' => '隆之介', 'family_name_kana' => 'なかはら', 'first_name_kana' => 'りゅうのすけ'],
            ['family_name' => '前川', 'first_name' => 'あさみ', 'family_name_kana' => 'まえかわ', 'first_name_kana' => 'あさみ'],
            ['family_name' => '石田', 'first_name' => '蒼太', 'family_name_kana' => 'いしだ', 'first_name_kana' => 'そうた'],
            ['family_name' => '鈴木', 'first_name' => '知里', 'family_name_kana' => 'すずき', 'first_name_kana' => 'ちさと'],
            ['family_name' => '村上', 'first_name' => '亜美', 'family_name_kana' => 'むらかみ', 'first_name_kana' => 'あみ'],
            ['family_name' => '中川', 'first_name' => '瑛斗', 'family_name_kana' => 'なかがわ', 'first_name_kana' => 'あきと'],
            ['family_name' => '渡辺', 'first_name' => '光子', 'family_name_kana' => 'わたなべ', 'first_name_kana' => 'みつこ'],
            ['family_name' => '西尾', 'first_name' => '明日香', 'family_name_kana' => 'にしお', 'first_name_kana' => 'あすか'],
            ['family_name' => '青木', 'first_name' => '航平', 'family_name_kana' => 'あおき', 'first_name_kana' => 'こうへい'],
            ['family_name' => '森田', 'first_name' => '祐二', 'family_name_kana' => 'もりた', 'first_name_kana' => 'ゆうじ'],
            ['family_name' => '吉田', 'first_name' => '紗英', 'family_name_kana' => 'よしだ', 'first_name_kana' => 'さえ'],
            ['family_name' => '岡田', 'first_name' => 'さゆり', 'family_name_kana' => 'おかだ', 'first_name_kana' => 'さゆり'],
            ['family_name' => '平田', 'first_name' => '真人', 'family_name_kana' => 'ひらた', 'first_name_kana' => 'まさと'],
            ['family_name' => '田口', 'first_name' => '里佳', 'family_name_kana' => 'たぐち', 'first_name_kana' => 'りか'],
            ['family_name' => '長谷川', 'first_name' => '優', 'family_name_kana' => 'はせがわ', 'first_name_kana' => 'ゆう'],
            ['family_name' => '荒川', 'first_name' => '和也', 'family_name_kana' => 'あらかわ', 'first_name_kana' => 'かずや'],
            ['family_name' => '川田', 'first_name' => '春香', 'family_name_kana' => 'かわだ', 'first_name_kana' => 'はるか'],
            ['family_name' => '本田', 'first_name' => '裕太', 'family_name_kana' => 'ほんだ', 'first_name_kana' => 'ゆうた'],
            ['family_name' => '高橋', 'first_name' => '恵美', 'family_name_kana' => 'たかはし', 'first_name_kana' => 'えみ'],
            ['family_name' => '浜田', 'first_name' => '大地', 'family_name_kana' => 'はまだ', 'first_name_kana' => 'だいち'],
            ['family_name' => '中山', 'first_name' => '香織', 'family_name_kana' => 'なかやま', 'first_name_kana' => 'かおり'],
            ['family_name' => '横山', 'first_name' => '剛史', 'family_name_kana' => 'よこやま', 'first_name_kana' => 'ごうじ'],
            ['family_name' => '石田', 'first_name' => '真紀', 'family_name_kana' => 'いしだ', 'first_name_kana' => 'まき'],
            ['family_name' => '小林', 'first_name' => '翔太', 'family_name_kana' => 'こばやし', 'first_name_kana' => 'しょうた'],
            ['family_name' => '福田', 'first_name' => '裕也', 'family_name_kana' => 'ふくだ', 'first_name_kana' => 'ゆうや'],
            ['family_name' => '杉山', 'first_name' => '裕美子', 'family_name_kana' => 'すぎやま', 'first_name_kana' => 'ゆみこ'],
            ['family_name' => '内田', 'first_name' => '健太', 'family_name_kana' => 'うちだ', 'first_name_kana' => 'けんた'],
            ['family_name' => '佐野', 'first_name' => '美和', 'family_name_kana' => 'さの', 'first_name_kana' => 'みわ'],
            ['family_name' => '菅原', 'first_name' => '遼太', 'family_name_kana' => 'すがわら', 'first_name_kana' => 'りょうた'],
            ['family_name' => '坂本', 'first_name' => '愛子', 'family_name_kana' => 'さかもと', 'first_name_kana' => 'あいこ'],
            ['family_name' => '堀田', 'first_name' => '浩司', 'family_name_kana' => 'ほりた', 'first_name_kana' => 'こうじ'],
            ['family_name' => '高田', 'first_name' => '愛菜', 'family_name_kana' => 'たかだ', 'first_name_kana' => 'あいな'],
            ['family_name' => '上田', 'first_name' => '芳子', 'family_name_kana' => 'うえだ', 'first_name_kana' => 'ようこ'],
            ['family_name' => '中田', 'first_name' => '慎太郎', 'family_name_kana' => 'なかた', 'first_name_kana' => 'しんたろう'],
            ['family_name' => '富田', 'first_name' => '結衣子', 'family_name_kana' => 'とみた', 'first_name_kana' => 'ゆいこ'],
            ['family_name' => '大西', 'first_name' => '大輝', 'family_name_kana' => 'おおにし', 'first_name_kana' => 'だいき'],
            ['family_name' => '野村', 'first_name' => '彩花', 'family_name_kana' => 'のむら', 'first_name_kana' => 'あやか'],
            ['family_name' => '安藤', 'first_name' => '博之', 'family_name_kana' => 'あんどう', 'first_name_kana' => 'ひろゆき'],
            ['family_name' => '岩田', 'first_name' => '愛華', 'family_name_kana' => 'いわた', 'first_name_kana' => 'あいか'],
            ['family_name' => '村田', 'first_name' => '裕子', 'family_name_kana' => 'むらた', 'first_name_kana' => 'ゆうこ'],
            ['family_name' => '坪井', 'first_name' => '愛美', 'family_name_kana' => 'つぼい', 'first_name_kana' => 'あみ'],
            ['family_name' => '高山', 'first_name' => '裕司', 'family_name_kana' => 'たかやま', 'first_name_kana' => 'ひろし'],
            ['family_name' => '田中', 'first_name' => '明日香', 'family_name_kana' => 'たなか', 'first_name_kana' => 'あすか'],
            ['family_name' => '福田', 'first_name' => '健一', 'family_name_kana' => 'ふくだ', 'first_name_kana' => 'けんいち'],
            ['family_name' => '伊藤', 'first_name' => '葵', 'family_name_kana' => 'いとう', 'first_name_kana' => 'あおい'],
            ['family_name' => '山田', 'first_name' => '智樹', 'family_name_kana' => 'やまだ', 'first_name_kana' => 'ともき'],
            ['family_name' => '小林', 'first_name' => '麻美', 'family_name_kana' => 'こばやし', 'first_name_kana' => 'あさみ'],
            ['family_name' => '石川', 'first_name' => '龍一', 'family_name_kana' => 'いしかわ', 'first_name_kana' => 'りゅういち'],
            ['family_name' => '西村', 'first_name' => '直美', 'family_name_kana' => 'にしむら', 'first_name_kana' => 'なおみ'],
            ['family_name' => '平野', 'first_name' => '遥', 'family_name_kana' => 'ひらの', 'first_name_kana' => 'はるか'],
            ['family_name' => '河村', 'first_name' => '千秋', 'family_name_kana' => 'かわむら', 'first_name_kana' => 'ちあき'],
            ['family_name' => '清水', 'first_name' => '健次', 'family_name_kana' => 'しみず', 'first_name_kana' => 'けんじ'],
            ['family_name' => '前田', 'first_name' => '幸恵', 'family_name_kana' => 'まえだ', 'first_name_kana' => 'ゆきえ'],
            ['family_name' => '松本', 'first_name' => '秀樹', 'family_name_kana' => 'まつもと', 'first_name_kana' => 'ひでき'],
            ['family_name' => '斉藤', 'first_name' => '優美', 'family_name_kana' => 'さいとう', 'first_name_kana' => 'ゆみ'],
            ['family_name' => '小川', 'first_name' => '康夫', 'family_name_kana' => 'おがわ', 'first_name_kana' => 'やすお'],
            ['family_name' => '加藤', 'first_name' => '瞳', 'family_name_kana' => 'かとう', 'first_name_kana' => 'ひとみ'],
            ['family_name' => '竹内', 'first_name' => '勇輝', 'family_name_kana' => 'たけうち', 'first_name_kana' => 'ゆうき'],
        ];
    }
}
