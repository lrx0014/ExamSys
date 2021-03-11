pipeline {
  agent {
    node {
      label 'docker'
    }

  }
  stages {
    stage('build') {
      steps {
        sh '''docker build -t lrx0014/examsys:auto-build .

echo "build finished"'''
      }
    }

    stage('push') {
      agent {
        node {
          label 'docker'
        }

      }
      environment {
        username = 'lrx0014'
        pwd = 'Dwmmsbc199656'
      }
      steps {
        sh '''echo "login into docker hub"

docker login -u ${username} -p ${pwd}

echo "pushing image"

docker push lrx0014/examsys:auto-build

echo "push finished"'''
      }
    }

  }
}